<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModeloAtpveController extends Controller
{
    //
    public function store(Request $request)
{
    \App\Models\ModeloAtpve::updateOrCreate(
        ['user_id' => auth()->id()],
        [
            'conteudo' => $request->conteudo,
            'cidade_padrao' => $request->cidade
        ]
    );

    return back()->with('success', 'Modelo ATPV-e atualizado com sucesso!');
}
}
