<?php

namespace App\Http\Controllers;

use App\Models\ModeloComunicacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModeloComunicacaoController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $empresaId = $user->empresa_id ?? $user->id;

        $request->validate([
            'outorgados' => 'required', // Array vindo do form
            'conteudo'   => 'required',
            'cidade'     => 'required|string|max:255',
        ]);

        try {
            ModeloComunicacao::create([
                'user_id'    => $user->id,
                'empresa_id' => $empresaId,
                'outorgados' => $request->outorgados,
                'conteudo'   => $request->conteudo,
                'cidade'     => $request->cidade,
            ]);

            return redirect()->back()->with('success', 'Modelo de comunicação salvo com sucesso!');
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao salvar: ' . $e->getMessage());
        }
    }
}