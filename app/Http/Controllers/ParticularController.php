<?php

namespace App\Http\Controllers;

use App\Models\Particular;
use Illuminate\Http\Request;

class ParticularController extends Controller
{
    public function index()
    {
        return Particular::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string',
            'cpf' => 'required|string',
            'fones' => 'required|array',
            'rua' => 'required|string',
            'numero' => 'required|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        return Particular::create($validated);
    }

    public function show(Particular $particular)
    {
        return $particular;
    }

    public function update(Request $request, Particular $particular)
    {
        $particular->update($request->all());
        return $particular;
    }

    public function destroy(Particular $particular)
    {
        $particular->delete();
        return response()->noContent();
    }
}