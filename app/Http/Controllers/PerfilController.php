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

        
        return view('perfil.index');
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
