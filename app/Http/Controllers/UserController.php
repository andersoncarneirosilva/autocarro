<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function index(Request $request){
        
        $search = $request->search;
        
        $users = $this->model->getUsers(search: $request->search ?? '');

        $title = 'Excluir!';
        $text = "Deseja excluir esse usuário?";
        confirmDelete($title, $text);

        return view('users.index', compact('users'));
    }
    
    public function show($id){
        if(!$user = $this->model->find($id)){
            return redirect()->route('users.index');
        }

        $title = 'Excluir!';
        $text = "Deseja excluir esse usuário?";
        confirmDelete($title, $text);
        
        return view('users.show', compact('user'));
    }
    //metodo para direcionar a pagina para o cadastro
    public function create(){
        return view('users.create');
    }
    //metodo para cadastrar o usuario no banco
    public function store(Request $request){
        $data = $request->all();
        //dd($data);
        $data['password'] = bcrypt($request->password);

        if(!$request->name){
            alert()->error('Campo nome é obrigatório!');
            return redirect()->route('users.create');
        }elseif(!$request->email){
            alert()->error('Campo email é obrigatório!');
            return redirect()->route('users.create');
        }elseif(!$request->telefone){
            alert()->error('Campo telefone é obrigatório!');
            return redirect()->route('users.create');
        }elseif(!$request->perfil){
            alert()->error('Campo perfil é obrigatório!');
            return redirect()->route('users.create');
        }elseif(!$request->password){
            alert()->error('Campo senha é obrigatório!');
            return redirect()->route('users.create');
        }elseif(!$request->password_confirm){
            alert()->error('Campo confirmar senha é obrigatório!');
            return redirect()->route('users.create');
        }elseif($request->password != $request->password_confirm){
            alert()->error('Senhas não coicidem!');
            return redirect()->route('users.create');
        }

        // Verifica se o email já existe no sistema
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            /* return response()->json(['error' => 'Email já cadastrado no sistema.']); */
            alert()->error('Email já cadastrado no sistema!');
            return redirect()->route('users.create');
        }

        if ($request->image) {
            $extension = $request->image->getClientOriginalExtension();
            $data['image'] = $request->image->storeAs("usuarios/{$request->name}/foto", $request->name . ".{$extension}");
        }
        
        if($this->model->create($data)){
            /* session()->flash('success', 'Usuário cadastrado com sucesso!'); */
            alert()->success('Usuário cadastrado com sucesso!');
            return redirect()->route('users.index');
        }
    }
    
    public function edit($id){
        
        if(!$user = $this->model->find($id)){
            return redirect()->route('users.index');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id){
        
        if($request->password){
            $data['password'] = bcrypt($request->password);
            $data['password_confirm'] = bcrypt($request->password);
        }else{
            $data = $request->except('password','password_confirm');
        }
        
        if(!$user = $this->model->find($id)){
            return redirect()->route('users.index');
        }

        if($request->image){
            $extension = $request->image->getClientOriginalExtension();
            $data['image'] = $request->image->storeAs("usuarios/{$request->name}/foto", $request->name . ".{$extension}");
        }

        if($request->password != $request->password_confirm){
            alert()->error('Senhas não coincidem!');
            return redirect()->route('users.edit', $id);
        }

        $user->update($data);
        alert()->success('Usuário editado com sucesso!');

        return redirect()->route('users.index');
    }

    public function destroy($id){
        //dd($id);
        if (Auth::user()->id === (int) $id) {
            alert()->error('Você não pode se excluir!');
            return redirect()->route('users.index');
        }

        if(!$user = $this->model->find($id)){
            return redirect()->route('users.index');
        }
        
        if($user->delete()){
            alert()->success('Usuário excluído com sucesso!');
            return redirect()->route('users.index'); 
        }
    }
    
}