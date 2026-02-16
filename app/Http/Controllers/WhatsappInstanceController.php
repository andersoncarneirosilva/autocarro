<?php

namespace App\Http\Controllers;

use App\Models\WhatsappInstance;
use App\Services\EvolutionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WhatsappInstanceController extends Controller
{
    protected $evolution;

    public function __construct(EvolutionService $evolution)
    {
        $this->evolution = $evolution;
    }

    public function index()
    {
        // Se estiver usando a Trait Multi-Tenant, o all() já filtrará por empresa_id
        $instances = WhatsappInstance::all();
        $settings = \App\Models\WhatsappSetting::first() ?? new \App\Models\WhatsappSetting();
        return view('whatsapp.index', compact('instances','settings'));
    }



public function store(Request $request)
{
    $baseUrl = rtrim(env('EVOLUTION_API_URL', 'http://evolution-api:8080'), '/');
    $apiKey = env('EVOLUTION_API_KEY', 'alcecar_secret_token');
    $empresaId = auth()->user()->empresa_id;

    // 1. BUSCA A INSTÂNCIA ATUAL NO BANCO (Antes de gerar o novo nome)
    $instanciaAntiga = WhatsappInstance::where('empresa_id', $empresaId)->first();

    if ($instanciaAntiga) {
        try {
            // Tenta dar Logout e Delete na instância antiga que o Laravel conhece
            Http::withHeaders(['apikey' => $apiKey])->post("{$baseUrl}/instance/logout/{$instanciaAntiga->name}");
            Http::withHeaders(['apikey' => $apiKey])->delete("{$baseUrl}/instance/delete/{$instanciaAntiga->name}");
            
            // Remove do banco para dar lugar à nova
            $instanciaAntiga->delete();
            
            // Pausa técnica para o Docker/API processar o encerramento dos arquivos
            usleep(800000); 
        } catch (\Exception $e) {
            Log::warning("Falha ao limpar instância antiga {$instanciaAntiga->name}: " . $e->getMessage());
        }
    }

    // 2. GERAÇÃO DO NOVO NOME COM RANDOM
    $nomeEmpresa = \Illuminate\Support\Str::slug(auth()->user()->empresa->nome ?? 'salao');
    $uniqueSuffix = \Illuminate\Support\Str::random(4);
    $instanceName = $nomeEmpresa . '_' . $empresaId . '_' . $uniqueSuffix; 

    // 3. TRATAMENTO DO NÚMERO
    $number = preg_replace('/\D/', '', $request->number);
    if (strlen($number) <= 11) { $number = '55' . $number; }

    // 4. CRIAÇÃO DA NOVA INSTÂNCIA
    try {
        $response = $this->callCreateInstance($instanceName, $number, $baseUrl, $apiKey);
        
        if ($response->successful()) {
            $data = $response->json();
            
            // Importante: Guardar o token específico da instância (hash->apikey)
            $instanceToken = $data['hash']['apikey'] ?? $apiKey;

            WhatsappInstance::create([
                'empresa_id' => $empresaId,
                'name'       => $instanceName,
                'number'     => $number,
                'status'     => 'disconnected',
                'token'      => $instanceToken 
            ]);

            return redirect()->back()->with('success', 'Nova instância gerada! Escaneie o QR Code.');
        }

        // Caso a API retorne erro (como o erro "C" de conflito)
        $errorMsg = $response->json('message') ?? 'Erro ao criar instância na API.';
        return redirect()->back()->with('error', 'Erro na API: ' . $errorMsg);

    } catch (\Exception $e) {
        Log::error('Erro crítico no WhatsApp Store: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erro interno no servidor.');
    }
}

private function callCreateInstance($instanceName, $number, $baseUrl, $apiKey)
{
    $url = rtrim($baseUrl, '/') . '/instance/create';

    // O segredo: A Evolution API v1 costuma exigir esses campos exatos
    $payload = [
        'instanceName' => (string) $instanceName,
        'token'        => (string) Str::random(16), // Token interno da instância
        'qrcode'       => true
    ];

    Log::info('WhatsApp Store: Enviando Payload via asJson', [
        'url' => $url,
        'payload' => $payload
    ]);

    return \Illuminate\Support\Facades\Http::withHeaders([
        'apikey' => (string) $apiKey,
    ])
    ->asJson() // Força o Header Content-Type: application/json
    ->acceptJson()
    ->post($url, $payload);
}
 public function connect($name)
{
    $baseUrl = env('EVOLUTION_API_URL');
    $apiKey = env('EVOLUTION_API_KEY');

    $response = Http::withHeaders(['apikey' => $apiKey])->get("{$baseUrl}/instance/connect/{$name}");

    // Se a instância sumiu da RAM (Modo Light), recriamos
    if ($response->status() === 404) {
        $local = \App\Models\WhatsappInstance::where('name', $name)->first();
        if ($local) {
            $this->callCreateInstance($name, $local->number, $baseUrl, $apiKey);
            sleep(2); 
            $response = Http::withHeaders(['apikey' => $apiKey])->get("{$baseUrl}/instance/connect/{$name}");
        }
    }

    $data = $response->json();

    // PEGA O BASE64 CORRETO DA v1.8.2
    // A API costuma retornar em $data['base64'] ou $data['qrcode']['base64']
    $qr = $data['base64'] ?? ($data['qrcode']['base64'] ?? null);

    return response()->json([
        'status' => 'success',
        'qrcode' => $qr // Mandamos apenas a string pura
    ]);
}

    /**
     * Sincroniza o status (utilizado pelo intervalo JS após o QR Code)
     */
    public function syncStatus($name)
    {
        try {
            $baseUrl = env('EVOLUTION_API_URL');
            $apiKey = env('EVOLUTION_API_KEY');

            $response = Http::withHeaders(['apikey' => $apiKey])
                ->get("{$baseUrl}/instance/connectionState/{$name}");

            $data = $response->json();
            $currentState = $data['instance']['state'] ?? 'disconnected';

            $instance = WhatsappInstance::where('name', $name)->first();
            
            if ($instance && $instance->status !== $currentState) {
                $instance->update(['status' => $currentState]);
            }

            return response()->json([
                'status' => $currentState,
                'instance' => $name
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Rota de Redirecionamento após conexão bem-sucedida
     */
    public function connectedSuccess()
    {
        return redirect()->route('whatsapp.index')
            ->with('success', 'Dispositivo pareado com sucesso!');
    }

    /**
     * Faz o Logout (Desconectar) na API
     */
    public function logout($name)
    {
        try {
            $baseUrl = env('EVOLUTION_API_URL');
            $apiKey = env('EVOLUTION_API_KEY');

            Http::withHeaders(['apikey' => $apiKey])->post("{$baseUrl}/instance/logout/{$name}");

            WhatsappInstance::where('name', $name)->update(['status' => 'disconnected']);

            return redirect()->back()->with('success', 'WhatsApp desconectado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao desconectar: ' . $e->getMessage());
        }
    }

    /**
     * Exclui a instância da API e do Banco (Botão Sim/Lado Direito com Swal)
     */
    
    // No WhatsappInstanceController.php

public function destroy($id)
{
    try {
        $instance = WhatsappInstance::findOrFail($id);
        $baseUrl = rtrim(env('EVOLUTION_API_URL'), '/');
        $apiKey = env('EVOLUTION_API_KEY');

        // 1. Tenta dar Logout (faz o celular desconectar na hora e limpa o socket)
        Http::withHeaders(['apikey' => $apiKey])
            ->post("{$baseUrl}/instance/logout/{$instance->name}");

        // 2. Tenta Deletar (limpa os arquivos da pasta /instances)
        Http::withHeaders(['apikey' => $apiKey])
            ->delete("{$baseUrl}/instance/delete/{$instance->name}");

        $instance->delete();

        return redirect()->back()->with('success', 'Conexão encerrada e removida!');
    } catch (\Exception $e) {
        if(isset($instance)) $instance->delete();
        return redirect()->back()->with('warning', 'Removido localmente. A API pode estar offline.');
    }
}

    

   public function sendTest(Request $request)
{
    try {
        $baseUrl = env('EVOLUTION_API_URL');
        $apiKey  = env('EVOLUTION_API_KEY');
        $instance = $request->instance;

        $number = preg_replace('/\D/', '', $request->number);
        if (substr($number, 0, 2) !== '55') {
            $number = '55' . $number;
        }

        // ESTRUTURA EXATA EXIGIDA PELA v1.8.2 (Conforme seu log de erro)
        $payload = [
            "number" => $number,
            "textMessage" => [
                "text" => (string) $request->message
            ]
        ];

        $response = Http::withHeaders([
            'apikey' => $apiKey,
            'Content-Type' => 'application/json'
        ])
        ->timeout(10)
        ->post("{$baseUrl}/message/sendText/{$instance}", $payload);

        if ($response->successful()) {
            return response()->json(['status' => 'success']);
        }

        // Se der erro, logamos para conferir
        \Log::error("Alcecar - Erro na Resposta: " . $response->body());
        
        return response()->json([
            'status' => 'error', 
            'message' => 'A API recusou o envio. Verifique se o dispositivo está pareado.'
        ], 400);

    } catch (\Exception $e) {
        \Log::error("Alcecar - Exception no Envio: " . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Erro interno ao enviar.'], 500);
    }
}

public function updateMessages(Request $request)
{
    $settings = \App\Models\WhatsappSetting::firstOrCreate(
        ['empresa_id' => auth()->user()->empresa_id]
    );

    // Lista de campos permitidos
    $fields = [
        'confirmation_is_active', 'cancellation_is_active', 'reminder_is_active', 'bot_is_active',
        'confirmation_template', 'cancellation_template', 'reminder_template', 'bot_template',
        'reminder_time', 'bot_cooldown'
    ];

    // Pega apenas os dados permitidos que estão presentes no request
    // O array_filter garante que não sobrescrevemos com nulo o que não foi enviado no form
    $data = array_filter($request->only($fields), function($value) {
        return $value !== null;
    });

    $settings->fill($data);
    $settings->save();

    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Status atualizado com sucesso!']);
    }

    return redirect()->back()->with('success', 'Configurações salvas com sucesso!');
}
}