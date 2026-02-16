<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function index()
{
    $empresaId = auth()->user()->empresa_id;

    if (!$empresaId) {
        return redirect()->route('dashboard.index')->with('error', 'Você não possui uma empresa vinculada.');
    }

    // Carregamos a empresa já trazendo as fotos da relação
    $empresa = Empresa::with('fotos')->find($empresaId);

    if (!$empresa) {
        return redirect()->route('dashboard.index')->with('error', 'Dados da empresa não encontrados.');
    }

    return view('empresa.index', compact('empresa'));
}

    public function update(Request $request, $id)
{
    $empresa = Empresa::findOrFail($id);

    $dados = $request->validate([
        'razao_social'     => 'required|string|max:255',
        'nome_responsavel' => 'required|string|max:255',
        'cnpj'             => 'nullable|string',
        'whatsapp'         => 'nullable|string',
        'logo'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'configuracoes'    => 'nullable|array', // Valida o array de redes sociais
    ]);

    // Mesclar as configurações novas com as existentes (para não perder a galeria ou outras chaves)
    $configuracoesAtuais = $empresa->configuracoes ?? [];
    if ($request->has('configuracoes')) {
        $dados['configuracoes'] = array_merge($configuracoesAtuais, $request->configuracoes);
    }

    if ($request->hasFile('logo')) {
        if ($empresa->logo) {
            \Storage::disk('public')->delete($empresa->logo);
        }
        $dados['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $empresa->update($dados);

    return redirect()->back()->with('success', 'Informações atualizadas com sucesso!');
}

public function updateGaleria(Request $request, $id)
{
    $empresa = Empresa::findOrFail($id);

    // 1. Remover fotos selecionadas (Banco e Storage)
    if ($request->has('remover_fotos')) {
        $fotosParaRemover = \App\Models\Galeria::whereIn('id', $request->remover_fotos)
                            ->where('empresa_id', $id)
                            ->get();

        foreach ($fotosParaRemover as $foto) {
            if (\Storage::disk('public')->exists($foto->caminho)) {
                \Storage::disk('public')->delete($foto->caminho);
            }
            $foto->delete();
        }
    }

    // 2. Upload de novas fotos respeitando o limite total de 10
    if ($request->hasFile('fotos')) {
        $quantidadeAtual = $empresa->fotos()->count();
        $novasFotos = $request->file('fotos');

        foreach ($novasFotos as $index => $arquivo) {
            if ($quantidadeAtual < 10) {
                $path = $arquivo->store('galerias/' . $empresa->id, 'public');
                
                $empresa->fotos()->create([
                    'caminho' => $path,
                    'ordem'   => $quantidadeAtual + 1,
                    'legenda' => 'Foto ' . ($quantidadeAtual + 1)
                ]);
                
                $quantidadeAtual++;
            }
        }
    }

    return redirect()->back()->with('success', 'Galeria atualizada com sucesso!');
}
public function deleteFoto($id)
{
    try {
        $foto = \App\Models\Galeria::findOrFail($id);
        
        // Verifica se a foto pertence à empresa do usuário logado (Segurança)
        if ($foto->empresa_id != auth()->user()->empresa_id) {
            return response()->json(['success' => false, 'message' => 'Não autorizado'], 403);
        }

        // Deleta o arquivo físico
        if (\Storage::disk('public')->exists($foto->caminho)) {
            \Storage::disk('public')->delete($foto->caminho);
        }

        // Deleta o registro no banco
        $foto->delete();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
}

}