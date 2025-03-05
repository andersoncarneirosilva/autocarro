<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    //
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function index()
    {

        $userId = Auth::id();
        $user = User::find($userId);

        $assinatura = $user->assinaturas()->latest()->first();

        if ($user->plano == 'Padrão' || $user->plano == 'Pro') {
            if (! $assinatura || now()->gt($assinatura->data_fim) || $assinatura->status == 'pending') {
                return redirect()->route('assinatura.expirada')->with('error', 'Sua assinatura expirou.');
            }
        }
        // dd($user);
        // Caminho para a pasta de documentos
        $path = storage_path("app/public/documentos/usuario_{$userId}");

        // Função para calcular o tamanho total da pasta
        function getFolderSize($folder)
        {
            $size = 0;
            foreach (glob(rtrim($folder, '/').'/*', GLOB_NOSORT) as $file) {
                $size += is_file($file) ? filesize($file) : getFolderSize($file);
            }

            return $size;
        }

        // Calcular o tamanho usado na pasta
        $usedSpaceInBytes = getFolderSize($path);
        $usedSpaceInMB = $usedSpaceInBytes / (1024 * 1024); // Converter para MB
        //dd($usedSpaceInMB);
        $limitInMB = $user->size_folder; // Limite de MB do usuario
        //dd($limitInMB);
        $percentUsed = ($usedSpaceInMB / $limitInMB) * 100; // Percentual usado



        // Função para listar arquivos e pastas
        $basePath = storage_path("app/public/documentos/usuario_{$userId}"); // Caminho do usuário


        // Obtém as pastas e arquivos do usuário
        $folders = $this->getFilesAndFolders($basePath, '', $userId);
        //dd($folders);
        // Passar as informações para a view
        return view('perfil.index', compact(['usedSpaceInMB', 'percentUsed', 'limitInMB', 'user', 'folders']));

    }

    private function getFilesAndFolders($path, $relativePath = '', $userId = null)
{
    $items = [];
    if (!File::exists($path)) {
        return $items;
    }

    // Processa as pastas
    foreach (File::directories($path) as $folder) {
        $folderName = basename($folder);
        $items[] = [
            'text' => $folderName,
            'children' => $this->getFilesAndFolders($folder, $relativePath . '/' . $folderName, $userId), // Recursividade
            'a_attr' => ['href' => ''] // Remove o link da pasta
        ];
    }

    // Processa os arquivos
    foreach (File::files($path) as $file) {
        $fileName = basename($file);
        // Aqui concatenamos o userId no caminho do arquivo
        $fileUrl = Storage::url("documentos/usuario_{$userId}" . $relativePath . "/" . $fileName); // Gera URL pública

        $items[] = [
            'text' => $fileName,
            'icon' => 'ri-file-line text-primary', // Ícone para arquivos
            'a_attr' => ['href' => $fileUrl, 'target' => '_blank'] // Link para abrir o arquivo
        ];
    }

    return $items;
}

    

// Para excluir o arquivo
public function deleteFiles(Request $request)
{
    $fileUrls = $request->input('fileUrls'); // Recebe um array de URLs de arquivos

    foreach ($fileUrls as $fileUrl) {
        $filePath = storage_path("app/public/{$fileUrl}");

        // Verifique se o arquivo realmente existe
        if (File::exists($filePath)) {
            File::delete($filePath); // Exclui o arquivo

            // Definir mensagem de sucesso na sessão
            session()->flash('success', 'Arquivo excluído com sucesso!');
        } else {
            session()->flash('error', 'Erro ao excluir o arquivo. Arquivo não encontrado.');
        }
    }

    return response()->json([
        'redirect' => route('perfil.index')
    ]);
}

public function deleteFolders(Request $request)
{
    $folderNames = $request->input('folderNames'); // Recebe um array de nomes de pastas
    $userId = auth()->id();

    foreach ($folderNames as $folderName) {
        $folderPath = storage_path("app/public/documentos/usuario_{$userId}/{$folderName}");

        // Verifica se a pasta existe e se é realmente um diretório
        if (File::exists($folderPath) && File::isDirectory($folderPath)) {
            // Exclui arquivos dentro da pasta
            $files = File::allFiles($folderPath); // Obtém todos os arquivos dentro da pasta
            foreach ($files as $file) {
                if (File::exists($file)) {
                    File::delete($file); // Exclui cada arquivo dentro da pasta
                }
            }

            // Agora exclui a pasta vazia
            File::deleteDirectory($folderPath);
            
            // Definir mensagem de sucesso na sessão
            session()->flash('success', 'Pastas e arquivos excluídos com sucesso!');
        } else {
            session()->flash('error', 'Erro ao excluir a pasta. Pasta não encontrada.');
        }
    }

    return response()->json([
        'redirect' => route('perfil.index')
    ]);
}






    





    public function edit($id)
    {
        // dd($id);
        if (! $user = $this->model->find($id)) {
            return redirect()->route('perfil.index');
        }

        return view('perfil.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Buscar o usuário no banco de dados
        if (! $user = $this->model->find($id)) {
            alert()->error('Usuário não encontrado!');

            return redirect()->route('perfil.index');
        }

        // Atualizar a senha apenas se preenchida
        if ($request->filled('password') || $request->filled('password_confirm')) {
            if (! $request->filled('password')) {
                alert()->error('Preencha o campo senha!');

                return redirect()->route('perfil.index');
            }
            if (! $request->filled('password_confirm')) {
                alert()->error('Preencha o campo confirmar senha!');

                return redirect()->route('perfil.index');
            }
            if ($request->password !== $request->password_confirm) {
                alert()->error('Senhas não coincidem!');

                return redirect()->route('perfil.index');
            }

            $user->password = bcrypt($request->password);
        }

        // Atualizar a imagem se for enviada
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $userFolder = 'usuarios/'.auth()->user()->name.'/foto';
            $fileName = uniqid().'.'.$extension; // Nome único

            // Salva a imagem e obtém o caminho
            $imagePath = $request->file('image')->storeAs($userFolder, $fileName, 'public');

            // Depuração para garantir que o caminho da imagem foi obtido corretamente
            // dd($imagePath);

            // Atualiza o caminho da imagem no banco de dados
            $user->image = $imagePath;
        }

        // Salvar as alterações
        $user->save();

        alert()->success('Perfil editado com sucesso!');

        return redirect()->route('perfil.index');
    }
}
