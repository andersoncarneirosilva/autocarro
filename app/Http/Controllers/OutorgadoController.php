<?php

namespace App\Http\Controllers;

use App\Models\ModeloProcuracao; // Ajustado para o nome correto do Model
use App\Models\Outorgado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OutorgadoController extends Controller
{
    protected $model;

    public function __construct(Outorgado $docs)
    {
        $this->model = $docs;
    }

    public function index(Request $request)
    {
        confirmDelete('Excluir!', 'Deseja excluir esse outorgado?');

        $user = Auth::user();
        $empresaId = $user->empresa_id ?? $user->id;

        // O método getSearch no seu Model deve ser ajustado para filtrar por empresa_id
        $outs = $this->model->getSearch($request->search, $empresaId);

        return view('outorgados.index', compact('outs'));
    }

    public function store(Request $request)
{
    $user = Auth::user();
    $empresaId = $user->empresa_id ?? $user->id;

    // 1. Validação básica de presença e formato
    $request->validate([
        'nome_outorgado'  => 'required|string|max:255',
        'end_outorgado'   => 'required|string|max:255',
        'email_outorgado' => 'required|email|max:255',
        'cpf_outorgado'   => 'required|string|max:14',
        'rg_outorgado'    => 'required|string|max:20',
    ]);

    // 2. Verificação Manual de Unicidade dentro da Empresa

    // Verificar E-mail
    if ($this->model->where('empresa_id', $empresaId)->where('email_outorgado', $request->email_outorgado)->exists()) {
        return redirect()->back()->withInput()->with('error', 'Este e-mail já está cadastrado nesta empresa.');
    }

    // Verificar CPF
    if ($this->model->where('empresa_id', $empresaId)->where('cpf_outorgado', $request->cpf_outorgado)->exists()) {
        return redirect()->back()->withInput()->with('error', 'Este CPF já está cadastrado nesta empresa.');
    }

    // Verificar RG
    if ($this->model->where('empresa_id', $empresaId)->where('rg_outorgado', $request->rg_outorgado)->exists()) {
        return redirect()->back()->withInput()->with('error', 'Este RG já está cadastrado nesta empresa.');
    }

    // 3. Preparação dos dados e criação
    $data = $request->all();
    $data['user_id']    = $user->id;
    $data['empresa_id'] = $empresaId;

    $this->model->create($data);

    return redirect()->route('outorgados.index')->with('success', 'Outorgado cadastrado com sucesso!');
}

    public function update(Request $request, $id)
{
    $user = Auth::user();
    $empresaId = $user->empresa_id ?? $user->id;

    // 1. Busca o registro ou falha
    $outorgado = $this->model->where('empresa_id', $empresaId)->findOrFail($id);

    // 2. Validação básica de campos obrigatórios e formatos
    $request->validate([
        'nome_outorgado'  => 'required|string|max:255',
        'cpf_outorgado'   => 'required|string|max:14',
        'rg_outorgado'    => 'required|string|max:20',
        'end_outorgado'   => 'required|string|max:255',
        'email_outorgado' => 'required|email|max:255',
    ]);

    // 3. Verificação Manual de Unicidade (Ignorando o próprio ID e filtrando por empresa)
    
    // Verificar CPF
    $cpfExiste = $this->model->where('empresa_id', $empresaId)
        ->where('cpf_outorgado', $request->cpf_outorgado)
        ->where('id', '!=', $id)
        ->exists();
    if ($cpfExiste) {
        return redirect()->back()->withInput()->with('error', 'Este CPF já está cadastrado para outro outorgado.');
    }

    // Verificar RG
    $rgExiste = $this->model->where('empresa_id', $empresaId)
        ->where('rg_outorgado', $request->rg_outorgado)
        ->where('id', '!=', $id)
        ->exists();
    if ($rgExiste) {
        return redirect()->back()->withInput()->with('error', 'Este RG já está cadastrado para outro outorgado.');
    }

    // Verificar E-mail
    $emailExiste = $this->model->where('empresa_id', $empresaId)
        ->where('email_outorgado', $request->email_outorgado)
        ->where('id', '!=', $id)
        ->exists();
    if ($emailExiste) {
        return redirect()->back()->withInput()->with('error', 'Este E-mail já está em uso na sua empresa.');
    }

    // 4. Se passou em tudo, atualiza
    $outorgado->update($request->all());

    return redirect()->route('outorgados.index')->with('success', 'Outorgado atualizado com sucesso!');
}

    public function show($id)
    {
        $empresaId = Auth::user()->empresa_id ?? Auth::id();
        
        $outorgado = $this->model->where('empresa_id', $empresaId)->findOrFail($id);

        return response()->json($outorgado);
    }

    public function destroy($id)
    {
        $empresaId = Auth::user()->empresa_id ?? Auth::id();
        
        $outorgado = $this->model->where('empresa_id', $empresaId)->findOrFail($id);

        // Busca modelos de procuração da EMPRESA que usam este outorgado
        $procuracoes = ModeloProcuracao::where('empresa_id', $empresaId)
            ->whereJsonContains('outorgados', (string) $id)
            ->get();

        foreach ($procuracoes as $procuracao) {
            $ids = is_array($procuracao->outorgados) ? $procuracao->outorgados : json_decode($procuracao->outorgados, true);
            $novosIds = array_values(array_diff($ids, [(string) $id]));

            if (empty($novosIds)) {
                $procuracao->delete();
            } else {
                $procuracao->update(['outorgados' => $novosIds]);
            }
        }

        $outorgado->delete();

        return redirect()->route('outorgados.index')->with('success', 'Outorgado excluído com sucesso!');
    }
}