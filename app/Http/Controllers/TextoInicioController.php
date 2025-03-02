<?php

namespace App\Http\Controllers;

use App\Models\ModeloProcuracoes;
use App\Models\TextoInicio;
use Illuminate\Http\Request;
use Parsedown;

class TextoInicioController extends Controller
{
    protected $model;

    public function __construct(TextoInicio $texts)
    {
        $this->model = $texts;
    }

    public function index(Request $request)
    {

        $title = 'Excluir!';
        $text = 'Deseja excluir essa categoria?';
        confirmDelete($title, $text);

        $texts = TextoInicio::paginate(10);

        // dd($docs);
        return view('configuracoes.index', compact('texts'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        if ($this->model->create($data)) {
            // Atualiza ou cria na tabela ModeloProcuracoes
            ModeloProcuracoes::updateOrCreate(
                ['id' => 1], // Substitua por critérios reais, se necessário
                [
                    'texto_inicial' => $data['texto_inicio'], // Salva o texto_inicio
                ]
            );

            alert()->success('Texto cadastrado com sucesso!');
        }

        return redirect()->route('configuracoes.index');
    }

    public function update(Request $request, $id)
    {

        $doc = TextoInicio::findOrFail($id);

        $doc->update($request->all());

        alert()->success('Texto editado com sucesso!');

        return redirect()->route('configuracoes.index');
    }

    public function show($id)
    {

        // dd($id);
        // Tente encontrar o documento pelo ID
        $configuracao = TextoInicio::find($id);

        // Verifique se o documento foi encontrado
        if (! $configuracao) {
            return response()->json(['error' => 'Configuração não encontrada'], 404);
        }

        // Se encontrado, converta o texto para HTML com Parsedown
        $parsedown = new Parsedown;
        $html = $parsedown->text($configuracao->texto_final);

        // Adicione o HTML processado ao objeto de resposta
        $configuracao->html = $html;

        // Retorne os dados, incluindo o HTML gerado
        return response()->json($configuracao);
    }

    public function destroy($id)
    {
        if (! $docs = $this->model->find($id)) {
            alert()->error('Erro ao excluír o texto!');
        }

        if ($docs->delete()) {
            alert()->success('Texto excluído com sucesso!');
        }

        return redirect()->route('configuracoes.index');
    }
}
