<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function index(Request $request)
{
    $search = $request->query('search');

    $users = User::when($search, function ($query, $search) {
        return $query->where('name', 'LIKE', "%{$search}%")
                     ->orWhere('email', 'LIKE', "%{$search}%")
                     ->orWhere('telefone', 'LIKE', "%{$search}%");
    })
    ->paginate(10);

    return view('users.index', compact('users'));
}

    public function show($id)
    {
        if (! $user = $this->model->find($id)) {
            return redirect()->route('users.index');
        }

        $title = 'Excluir!';
        $text = 'Deseja excluir esse usuário?';
        confirmDelete($title, $text);

        return view('users.show', compact('user'));
    }


    // metodo para cadastrar o usuario no banco
    public function store(Request $request)
{
    try {
        // 1. Validação
        $validatedData = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'telefone'     => 'required|string',
            'nivel_acesso' => 'required|string',
            'password'     => 'required|string|min:8|confirmed',
            'image'        => 'nullable|image|max:2048',
            // Removido o status da validação pois vamos forçar o valor abaixo
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        
        // FORÇANDO O STATUS COMO ATIVO
        $data['status'] = 'Ativo';

        // 2. Upload da Imagem
        if ($request->hasFile('image')) {
            $nameSlug = Str::slug($request->name);
            $extension = $request->image->getClientOriginalExtension();
            $fileName = $nameSlug . "_" . time() . "." . $extension;
            $data['image'] = $request->image->storeAs("usuarios/{$nameSlug}", $fileName, 'public');
        }

        // 3. Criação
        User::create($data);

        return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso!');

    } catch (ValidationException $e) {
        $firstError = $e->validator->errors()->first();
        
        return redirect()->back()
            ->with('error', $firstError)
            ->withErrors($e->validator)
            ->withInput();
            
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Erro ao cadastrar: ' . $e->getMessage())
            ->withInput();
    }
}


    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,' . $id, // Ignora o próprio usuário
        'telefone' => 'required',
        'password' => 'nullable|string|min:6|confirmed', // Senha não é mais obrigatória
    ]);

    $data = $request->only(['name', 'email', 'telefone', 'nivel_acesso', 'status']);

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    // Lógica da imagem...
    
    $user->update($data);

    return redirect()->route('users.index')->with('success', 'Usuário atualizado!');
}

    public function destroy($id)
    {
        // dd($id);
        if (Auth::user()->id === (int) $id) {
            return redirect()->route('users.index')->with('error', 'Você não pode se excluir!');
        }

        if (! $user = $this->model->find($id)) {
            return redirect()->route('users.index')->with('error', 'Usuário não encontrado!');
        }

        if ($user->delete()) {
            return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
        }
    }
}
