<?php

namespace App\Http\Controllers;

use App\Models\Galeria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriaController extends Controller
{
    public function index()
    {
        // Pega as fotos apenas da empresa do usuário logado
        $fotos = Galeria::where('empresa_id', auth()->user()->empresa_id)->orderBy('ordem', 'asc')->get();
        return view('galeria.index', compact('fotos'));
    }

    public function store(Request $request)
{
    $request->validate([
        'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        'legenda' => 'nullable|string|max:100',
        'ordem' => 'nullable|integer'
    ]);

    $empresaId = auth()->user()->empresa_id;

    if ($request->hasFile('foto')) {
        // Gera um nome único e limpo: empresa_id + timestamp + aleatorio
        $extensao = $request->file('foto')->getClientOriginalExtension();
        $nomeLimpo = "foto_" . time() . "_" . uniqid() . "." . $extensao;
        
        // Salva na pasta da empresa
        $path = $request->file('foto')->storeAs(
            "galeria/{$empresaId}", 
            $nomeLimpo, 
            'public'
        );

        Galeria::create([
            'empresa_id' => $empresaId,
            'caminho'    => $path, // Vai salvar: "galeria/1/foto_12345.jpg"
            'legenda'    => $request->legenda,
            'ordem'      => $request->ordem ?? 0
        ]);

        return back()->with('success', 'Foto adicionada com sucesso!');
    }

    return back()->with('error', 'Erro ao carregar foto.');
}

    public function destroy(Galeria $galeria)
    {
        // Segurança: Impede que um usuário delete fotos de outra empresa
        if ((int) $galeria->empresa_id !== (int) auth()->user()->empresa_id) {
            abort(403, 'Ação não autorizada.');
        }

        // Deleta o arquivo físico do storage
        if (Storage::disk('public')->exists($galeria->caminho)) {
            Storage::disk('public')->delete($galeria->caminho);
        }

        $galeria->delete();

        return back()->with('success', 'Foto removida!');
    }
}