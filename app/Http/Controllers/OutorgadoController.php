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

        $request->validate([
            'nome_outorgado' => 'required|string|max:255',
            'end_outorgado'  => 'required|string|max:255',
            'email_outorgado' => [
                'required', 'email', 'max:255',
                // Valida unicidade apenas dentro da mesma empresa
                Rule::unique('outorgados', 'email_outorgado')->where('empresa_id', $empresaId),
            ],
            'cpf_outorgado' => [
                'required', 'string', 'max:14',
                // Valida unicidade apenas dentro da mesma empresa
                Rule::unique('outorgados', 'cpf_outorgado')->where('empresa_id', $empresaId),
            ],
        ], [
            'email_outorgado.unique' => 'Este e-mail já está cadastrado nesta empresa.',
            'cpf_outorgado.unique'   => 'Este CPF já está cadastrado nesta empresa.',
        ]);

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

        // Busca o outorgado garantindo que pertence à empresa
        $outorgado = $this->model->where('empresa_id', $empresaId)->findOrFail($id);

        $validated = $request->validate([
            'nome_outorgado' => 'required|string|max:255',
            'cpf_outorgado'  => [
                'required', 'string', 'max:14',
                Rule::unique('outorgados', 'cpf_outorgado')->ignore($id)->where('empresa_id', $empresaId)
            ],
            'end_outorgado'  => 'required|string|max:255',
            'email_outorgado' => [
                'required', 'email', 'max:255',
                Rule::unique('outorgados', 'email_outorgado')->ignore($id)->where('empresa_id', $empresaId)
            ],
        ]);

        $outorgado->update($validated);

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