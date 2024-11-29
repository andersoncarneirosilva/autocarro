<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $model;

    public function __construct(Employee $emp)
    {
        $this->model = $emp;
    }

    public function index(Request $request){
        
        $search = $request->search;

        $employees = $this->model->getEmployees(search: $request->search ?? '');

        return view('employees.index', compact('employees'));
    }
    //metodo exibir o usuario
    public function show($id){
        if(!$employee = $this->model->find($id)){
            return redirect()->route('employees.index');
        }

        $title = 'Excluir!';
        $text = "Deseja excluir esse usuário?";
        confirmDelete($title, $text);
        
        return view('employees.show', compact('employee'));
    }
    //metodo para direcionar a pagina para o cadastro
    public function create(){
        return view('employees.create');
    }
    //metodo para cadastrar o usuario no banco
    public function store(Request $request){
        //dd($request->all());
        $data = $request->all();
        //dd($data);
        $data['password'] = bcrypt($request->password);
        
        if(!$request->name){
            return response()->json(['error' => 'Preencha o nome!']);
        }elseif(!$request->email){
            return response()->json(['error' => 'Preencha o email!']);
        }elseif(!$request->telefone){
            return response()->json(['error' => 'Campo telefone é obrigatório!']);
        }elseif(!$request->perfil){
            return response()->json(['error' => 'Campo perfil é obrigatório!']);
        }elseif(!$request->cargo){
            return response()->json(['error' => 'Campo cargo é obrigatório!']);
        }elseif(!$request->nascimento){
            return response()->json(['error' => 'Campo data de nascimento é obrigatório!']);
        }elseif(!$request->cep){
            return response()->json(['error' => 'Campo cep é obrigatório!']);
        }elseif(!$request->logradouro){
            return response()->json(['error' => 'Campo logradouro é obrigatório!']);
        }elseif(!$request->bairro){
            return response()->json(['error' => 'Campo bairro é obrigatório!']);
        }elseif(!$request->cidade){
            return response()->json(['error' => 'Campo cidade é obrigatório!']);
        }elseif(!$request->estado){
            return response()->json(['error' => 'Campo estado é obrigatório!']);
        }elseif(!$request->complemento){
            return response()->json(['error' => 'Campo complemento é obrigatório!']);
        }elseif(!$request->password){
            return response()->json(['error' => 'Campo senha é obrigatório!']);
        }elseif(!$request->password_confirm){
            return response()->json(['error' => 'Necessário confirmar a senha!']);
        }elseif($request->password != $request->password_confirm){
            return response()->json(['error' => 'As senhas não coicidem!']);
        }

        if ($request->image) {
            $extension = $request->image->getClientOriginalExtension();
            $data['image'] = $request->image->storeAs("employees/{$request->name}", $request->name . ".{$extension}");
        }
        
        if($this->model->create($data)){
            session()->flash('success', 'Usuário cadastrado com sucesso!');
            return response()->json(['success' => true]);
        }
    }

    
    //direcionar para a pagina EDITAR usuario. se nao existe o usuario retorna para index
    public function edit($id){
        //dd($id);
        if(!$employee = $this->model->find($id)){
            return redirect()->route('employees.index');
        }
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, $id){
        
        if($request->password){
            $data['password'] = bcrypt($request->password);
            $data['password_confirm'] = bcrypt($request->password);
        }else{
            $data = $request->except('password','password_confirm');
        }
        
        if(!$user = $this->model->find($id)){
            return redirect()->route('employees.index');
        }

        if($request->image){
            $data['image'] = $request->image->store('employees');
        }

        if($request->password != $request->password_confirm){
            alert()->error('Senhas não coincidem!');
            return redirect()->route('employees.edit', $id);
        }

        $user->update($data);
        alert()->success('Colaborador editado com sucesso!');

        return redirect()->route('employees.index');
    }

    /* public function destroy($id){
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
    } */

    public function destroy($id)
    {
        $user = Employee::find($id);

        if ($user) {
            $user->delete();
            return response()->json(['message' => 'Colaborador excluído com sucesso!']);
        }

        return response()->json(['message' => 'Colaborador não encontrado.']);
    }
    

    public function deleteAll(Request $request){
        $ids = $request->ids;
        //dd($ids);
        Employee::whereIn('id', $ids)->delete();
        //alert()->success('Usuários excluídos com sucesso!');
        return response()->json([
            'success' => true,
            'message' => 'Colaborador excluídos com sucesso!'
      ]);
        
    }
}
