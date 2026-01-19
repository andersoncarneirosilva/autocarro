<?php
namespace App\Http\Controllers;

use App\Models\Revenda;
use Illuminate\Http\Request;

class RevendaController extends Controller
{
    public function index()
    {
        return Revenda::all();
    }

    public function store(Request $request)
    {
        //dd($request);
        $data = $request->validate([
            'nome'    => 'required|string|max:255',
            'fones'   => 'required|array',
            'rua'     => 'required|string|max:255',
            'numero'  => 'required|string|max:20',
            'bairro'  => 'required|string|max:255',
            'cidade'  => 'required|string|max:255',
            'estado'  => 'required|string|size:2',
            'cep'     => 'required|string|max:10',
        ]);

        return Revenda::create($data);
    }

    public function show(Revenda $revenda)
    {
        return $revenda;
    }

    public function update(Request $request, Revenda $revenda)
    {
        $data = $request->validate([
            'nome'    => 'sometimes|string|max:255',
            'fones'   => 'sometimes|array',
            'rua'     => 'sometimes|string|max:255',
            'numero'  => 'sometimes|string|max:20',
            'bairro'  => 'sometimes|string|max:255',
            'cidade'  => 'sometimes|string|max:255',
            'estado'  => 'sometimes|string|size:2',
            'cep'     => 'sometimes|string|max:10',
        ]);

        $revenda->update($data);

        return $revenda;
    }

    public function destroy(Revenda $revenda)
    {
        $revenda->delete();

        return response()->noContent();
    }
}
