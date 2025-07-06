<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class AnuncioController extends Controller
{
    protected $model;

    public function __construct(Anuncio $user)
    {
        $this->model = $user;
    }

    public function index(){

        $veiculos = Anuncio::paginate(10);
        return view('anuncios.index', compact('veiculos'));
    }

    public function create(){

        return view('anuncios.create');
    }

    public function store(Request $request)
{
    $data = $request->all();
    //dd($data);
    $paths = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            $extension = $image->getClientOriginalExtension();
            $filename = $request->modelo . '_' . Str::random(10) . '.' . $extension;
            $path = $image->storeAs("veiculos/{$request->marca}/fotos", $filename);
            $paths[] = $path;
        }
        $data['images'] = json_encode($paths); // salva como JSON no banco
    }

    if ($this->model->create($data)) {
        return redirect()->route('anuncios.index')->with('success', 'Anúncio cadastrado com sucesso!');
    }
}


    public function show($id)
    {
        // dd($id);
        if (! $veiculo = $this->model->find($id)) {
            return redirect()->route('anuncios.index');
        }
        //dd($veiculo);

        return view('anuncios.show', compact('veiculo'));
    }

    public function update(Request $request, $id)
    {
        $anuncio = Anuncio::findOrFail($id);

        $validated = $request->validate([
            'marca' => 'sometimes|required|string',
            'modelo' => 'sometimes|required|string',
            'ano' => 'sometimes|required|integer|min:1900|max:' . date('Y'),
            'kilometragem' => 'sometimes|required|integer|min:0',
            'cor' => 'sometimes|required|string',
            'cambio' => 'sometimes|required|string',
            'portas' => 'sometimes|required|integer|min:1|max:5',
            'observacoes' => 'nullable|string',
        ]);

        $anuncio->update($validated);

        return $anuncio;
    }

    public function destroy($id)
    {
        // dd($id);

        if (! $veiculo = $this->model->find($id)) {
            return redirect()->route('anuncios.index')->with('error', 'Veículo não encontrado!');
        }

        if ($veiculo->delete()) {
            return redirect()->route('anuncios.index')->with('success', 'Veículo excluído com sucesso!');
        }
    }

    public function arquivar($id)
{
    $veiculo = $this->model->find($id); // busca o veículo

    if (!$veiculo) {
        return back()->with('error', 'Erro ao arquivar o veículo!');
    }

    $veiculo->update(['status' => 'Arquivado']);

    return back()->with('success', 'Veículo arquivado com sucesso!');
}

public function desarquivar($id)
{
    $veiculo = $this->model->find($id); // busca o veículo

    if (!$veiculo) {
        return back()->with('error', 'Erro ao restaurar o veículo!');
    }

    $veiculo->update(['status' => 'Ativo']);

    return back()->with('success', 'Veículo restaurado com sucesso!');
}

public function temp(Request $request)
{
    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('temp', 'public');
        return response()->json(['path' => $path]);
    }
    return response()->json(['error' => 'Nenhum arquivo enviado.'], 400);
}


}