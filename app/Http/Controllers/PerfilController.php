<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

        
        return view('perfil.index', compact(['user']));

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
    $fileUrls = $request->input('fileUrls'); // Recebe as URLs dos arquivos a serem excluídos
    $userId = auth()->id(); // Obtém o ID do usuário autenticado

    if (!is_array($fileUrls)) {
        Log::error('Dados inválidos recebidos para exclusão de arquivos', ['request' => $request->all()]);
        return response()->json(['error' => 'Dados inválidos'], 400);
    }

    foreach ($fileUrls as $fileUrl) {
        // Extraímos o nome do arquivo e o diretório da URL (sem manipulação da URL)
        $pathInfo = parse_url($fileUrl, PHP_URL_PATH);  // Obtém o caminho da URL

        // Verifica se o caminho contém os elementos esperados (usuário, pasta, arquivo)
        $pathParts = explode('/', trim($pathInfo, '/'));
        
        if (count($pathParts) < 4) {
            Log::warning('Formato inválido de URL recebido', ['fileUrl' => $fileUrl]);
            continue; // Ignora esta URL e passa para a próxima
        }

        // A partir do caminho da URL, obtém o ID do usuário, pasta e nome do arquivo
        $userIdFromUrl = $pathParts[2];  // ID do usuário da URL
        $folderName = $pathParts[3];      // Nome da pasta
        $fileName = $pathParts[4];        // Nome do arquivo

        // Monta o caminho correto do arquivo
        $filePath = storage_path("app/public/documentos/usuario_{$userId}/{$folderName}/{$fileName}");

        // Loga o caminho do arquivo para depuração
        Log::info('Tentando excluir o arquivo', ['filePath' => $filePath]);

        try {
            // Verifica se o arquivo realmente existe antes de excluir
            if (File::exists($filePath)) {
                File::delete($filePath); // Exclui o arquivo
                session()->flash('success', 'Arquivo excluído com sucesso!');
                Log::info('Arquivo excluído com sucesso', ['filePath' => $filePath]);
            } else {
                session()->flash('error', 'Erro ao excluir o arquivo. Arquivo não encontrado.');
                \Log::warning('Arquivo não encontrado para exclusão', ['filePath' => $filePath]);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao excluir o arquivo: ' . $e->getMessage());
            Log::error('Erro ao excluir o arquivo', [
                'filePath' => $filePath,
                'exception' => $e->getMessage(),
            ]);
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
