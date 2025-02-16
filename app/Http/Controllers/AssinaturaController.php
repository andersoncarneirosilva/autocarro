<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Assinatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AssinaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Obtemos o ID do usuário logado
    $userId = Auth::id();

    // Buscamos as assinaturas do usuário com o filtro 'Ativo'
    $assinaturas = Assinatura::where('user_id', $userId)
                              ->orderBy('created_at', 'desc') // Ordena pelo mais recente
                              ->paginate(20); // Retorna os resultados paginados
    //DD($assinaturas);
    // Retorna a view com os dados
    return view('assinatura.index', compact('userId', 'assinaturas'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Assinatura $assinatura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assinatura $assinatura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assinatura $assinatura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assinatura $assinatura)
    {
        //
    }
}
