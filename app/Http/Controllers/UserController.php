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
        try {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'telefone' => 'required|string|max:15', 
                'perfil'     => 'required|string|max:255',
                'password' => 'required|string|min:6|confirmed',
                'classe' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'credito' => 'required|string|max:255',
            ]);
            //dd($validated);
            //dd($validated); // 🔴 ADICIONE ESTA LINHA PARA TESTAR SE A VALIDAÇÃO ESTÁ FUNCIONANDO
        } catch (\Illuminate\Validation\ValidationException $e) {
            $mensagemErro = implode("\n", $e->validator->errors()->all());
            alert()->error('Todos os campos são obrigatórios!', $mensagemErro);
            return redirect()->route('users.create')->withErrors($e->validator)->withInput();
        }

        $data['password'] = bcrypt($request->password);

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

            return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso!');
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
        return redirect()->route('users.index')->with('success', 'Usuário editado com sucesso!');
    }

    public function destroy($id){
        //dd($id);
        if (Auth::user()->id === (int) $id) {
            return redirect()->route('users.index')->with('error', 'Você não pode se excluir!');
        }

        if(!$user = $this->model->find($id)){
            return redirect()->route('users.index')->with('error', 'Usuário não encontrado!');
        }
        
        if($user->delete()){
            return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
        }
    }
    
}