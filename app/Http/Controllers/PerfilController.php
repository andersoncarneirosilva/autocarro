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
        $path = storage_path('app/public/documentos/usuario_'.auth()->id());

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
        $limitInMB = 1; // Limite de 1 MB
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

    

public function deleteFile(Request $request)
{
    $fileUrl = $request->input('fileUrl');
    $filePath = storage_path("app/public/{$fileUrl}");

    if (File::exists($filePath)) {
        File::delete($filePath);

        // Redireciona com sucesso e passamos o redirecionamento correto
        return response()->json([
            'redirect' => route('perfil.index'),
            'success' => 'Arquivo excluído com sucesso!'
        ]);
    }

    return response()->json([
        'redirect' => route('perfil.index'),
        'error' => 'Erro ao excluir o arquivo.'
    ]);
}

public function deleteFolder(Request $request)
{
    $folderName = $request->input('folderName');
    $userId = auth()->id();
    $folderPath = storage_path("app/public/documentos/usuario_{$userId}/{$folderName}");

    if (File::exists($folderPath) && File::isDirectory($folderPath)) {
        File::deleteDirectory($folderPath);

        // Redireciona com sucesso e passamos o redirecionamento correto
        return response()->json([
            'redirect' => route('perfil.index'),
            'success' => 'Pasta excluída com sucesso!'
        ]);
    }

    return response()->json([
        'redirect' => route('perfil.index'),
        'error' => 'Erro ao excluir a pasta.'
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
