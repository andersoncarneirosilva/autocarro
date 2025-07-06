<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FornecedorController extends Controller
{
   public function index(Request $request)
    {

        $title = 'Atenção';
        $text = 'Deseja excluir esse cliente?';
        confirmDelete($title, $text);

        // Obtendo o ID do usuário logado
        $userId = Auth::id();
        $user = User::find($userId);

        // Filtrando os clientes do usuário logado e realizando a pesquisa
        $clientes = Cliente::all();

        // dd($docs);
        return view('fornecedores.index', compact('clientes'));
    }
     public function create()
    {
        return view('fornecedores.create');
    }

public function consultarCnpj($cnpj)
{
    $cnpj = preg_replace('/\D/', '', $cnpj);
    $url = "https://www.receitaws.com.br/v1/cnpj/{$cnpj}";

    try {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get($url);

        return response()->json($response->json(), $response->status());
    } catch (\Exception $e) {
        return response()->json(['status' => 'ERROR', 'message' => 'Erro ao consultar CNPJ.'], 500);
    }
}
}
