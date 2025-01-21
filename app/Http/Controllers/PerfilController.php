<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PerfilController extends Controller
{
    //
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function index(){

        $path = storage_path('app/public/documentos/usuario_' . auth()->id());

    // Função para calcular o tamanho total da pasta
    function getFolderSize($folder)
    {
        $size = 0;
        foreach (glob(rtrim($folder, '/') . '/*', GLOB_NOSORT) as $file) {
            $size += is_file($file) ? filesize($file) : getFolderSize($file);
        }
        return $size;
    }

    // Calcular o tamanho usado na pasta
    $usedSpaceInBytes = getFolderSize($path);
    $usedSpaceInMB = $usedSpaceInBytes / (1024 * 1024); // Converter para MB
    $limitInMB = 1; // Limite de 1 MB
    $percentUsed = ($usedSpaceInMB / $limitInMB) * 100; // Percentual usado

    // Passar as informações para a view
    return view('perfil.index', compact(['usedSpaceInMB', 'percentUsed', 'limitInMB']));
        

    }

    public function edit($id){
        //dd($id);
        if(!$user = $this->model->find($id)){
            return redirect()->route('perfil.index');
        }
        return view('perfil.edit', compact('user'));
    }

    public function update(Request $request, $id){

        //dd($request);
        $data = $request->all();
        //dd($data);
        if(!$request->password){
            alert()->error('Preencha o campo senha!');
            return redirect()->route('perfil.index');    
        }
        if(!$request->password_confirm){
            alert()->error('Preencha o campo confirmar senha!');
            return redirect()->route('perfil.index');    
        }
        if($request->password != $request->password_confirm){
            alert()->error('Senhas não coicidem!');
            return redirect()->route('perfil.index');    
        }
        if(!$user = $this->model->find($id))
            return redirect()->route('perfil.index');    

        $user->update($data);
        alert()->success('Perfil editado com sucesso!');
        return redirect()->route('perfil.index');
    }
}
