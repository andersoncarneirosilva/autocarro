<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(Pedido $pedido)
    {
        $this->model = $pedido;
    }

    public function index()
    {
        //
        $title = 'Excluir!';
        $text = "Deseja arquivar esse veículo?";
        confirmDelete($title, $text);
        
        $userId = Auth::id();
        $pedidos = Pedido::where('user_id', $userId)->paginate(10);

        return view('pedidos.index', compact(['pedidos']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pedidos.create');
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
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }

}
