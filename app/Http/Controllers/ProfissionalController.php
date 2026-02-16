<?php
namespace App\Http\Controllers;

use App\Models\Profissional;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// Importe a classe Controller base se estiver usando a estrutura padrão
use App\Http\Controllers\Controller; 

class ProfissionalController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();
    $empresaId = $user->empresa_id ?? $user->id;

    // 1. Busca os funcionários (para a listagem da tabela)
    $query = Profissional::where('empresa_id', $empresaId);

    if ($request->has('search')) {
        $query->where('nome', 'like', '%' . $request->search . '%');
    }

    $profissionais = $query->paginate(10);

    // 2. Busca os serviços do Alcecar (para os cards do Modal)
    // Se você ainda não tem a model Servico, crie-a.
    $servicos = Servico::where('empresa_id', $empresaId)
                                         ->orderBy('nome', 'asc')
                                         ->get();

    // 3. Envia AMBAS as variáveis para a View
    return view('profissionais.index', compact('profissionais', 'servicos'));
}

    /**
     * Salva um novo profissional no Alcecar
     */
    public function store(Request $request)
{
    // 1. Limpeza do Telefone (Removendo máscaras antes de processar)
    if ($request->filled('telefone')) {
        $telefoneLimpo = preg_replace('/\D/', '', $request->telefone);
        $request->merge(['telefone' => $telefoneLimpo]);
    }

    // 2. Filtra os serviços marcados
    $servicosFinal = collect($request->servicos_selecionados)
        ->filter(function($item) {
            return isset($item['id']); 
        })
        ->values()
        ->toArray();

    // 3. Inicializa o modelo
    $funcionario = new Profissional();
    
    // O fill agora pegará o telefone já limpo do request
    $funcionario->fill($request->except(['foto', 'password']));

    // 4. Lógica da Foto
    if ($request->hasFile('foto')) {
        $empresaId = auth()->user()->empresa_id ?? auth()->id();
        
        $extensao = $request->file('foto')->getClientOriginalExtension();
        $nomeArquivo = time() . '_' . uniqid() . '.' . $extensao;

        $path = $request->file('foto')->storeAs(
            "profissionais/{$empresaId}", 
            $nomeArquivo, 
            'public'
        );

        $funcionario->foto = $path; 
    }

    // 5. Atribuições Finais
    $funcionario->servicos = $servicosFinal;
    $funcionario->password = Hash::make($request->password);
    $funcionario->empresa_id = auth()->user()->empresa_id ?? auth()->id();
    $funcionario->user_id = auth()->id();
    
    $funcionario->save();

    return redirect()->back()->with('success', 'Profissional cadastrado com sucesso!');
}

public function update(Request $request, $id)
{
    $funcionario = Profissional::findOrFail($id);
    
    // 1. Limpeza do Telefone (Removendo máscaras)
    if ($request->filled('telefone')) {
        $telefoneLimpo = preg_replace('/\D/', '', $request->telefone);
        $request->merge(['telefone' => $telefoneLimpo]);
    }

    $servicosFinal = collect($request->servicos_selecionados)->filter(fn($i) => isset($i['id']))->values()->toArray();
    $horariosTrabalho = collect($request->horarios)->filter(fn($d) => isset($d['trabalha']))->toArray();

    $data = $request->except(['password', 'horarios', 'servicos_selecionados', 'foto']);
    
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    if ($request->hasFile('foto')) {
        $empresaId = auth()->user()->empresa_id ?? auth()->id();
        
        if ($funcionario->foto && \Storage::disk('public')->exists($funcionario->foto)) {
            \Storage::disk('public')->delete($funcionario->foto);
        }

        $extensao = $request->file('foto')->getClientOriginalExtension();
        $nomeArquivo = time() . '_' . uniqid() . '.' . $extensao;

        $path = $request->file('foto')->storeAs(
            "profissionais/{$empresaId}", 
            $nomeArquivo, 
            'public'
        );

        $funcionario->foto = $path; 
    }

    $funcionario->fill($data);
    $funcionario->servicos = $servicosFinal;
    $funcionario->horarios = $horariosTrabalho;
    $funcionario->save();

    return redirect()->back()->with('success', 'Profissional atualizado com sucesso!');
}

public function destroy($id)
{
    try {
        // Busca o funcionário na tabela 'funcionarios'
        $funcionario = Profissional::findOrFail($id);

        // Opcional: Se você quiser impedir que o ADMIN exclua a si mesmo da lista de profissionais,
        // mas permita excluir outros, a lógica seria:
        // if ($funcionario->email == auth()->user()->email) { ... }

        // Deleta o registro do funcionário
        $funcionario->delete();

        return redirect()->route('profissionais.index')->with('success', 'Profissional removido com sucesso!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erro ao excluir: ' . $e->getMessage());
    }
}

}