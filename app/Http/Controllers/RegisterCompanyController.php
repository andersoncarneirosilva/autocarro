<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Company;
use App\Models\DashModel;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class RegisterCompanyController extends Controller
{
    protected $model;

    public function __construct(DashModel $info)
    {
        $this->model = $info;
    }

    public function index(Request $request)
    {

        // $user= auth()->user();

        // $search = $request->search;

        // $infos = Company::where('id_user', $user->id)->first();

        return view('register.index');
    }

    public function create()
    {
        return view('register.create');
    }

    public function store(Request $request)
    {

        $data = $request->all();
        // dd($data);
        $existingTenant = Tenant::where('id', $request->domain)->first();
        $existingEmail = Tenant::where('email', $request->email)->first();
        // dd($existingTenant);
        if ($existingTenant) {
            /* return response()->json(['error' => 'Email já cadastrado no sistema.']); */
            // session()->flash('error', "Este nome já está um uso. Tente outro!");
            alert()->error('Este nome já está um uso. Tente outro.');

            // return view('register.create');
            return redirect()->route('register.create');
        }
        if ($existingEmail) {
            /* return response()->json(['error' => 'Email já cadastrado no sistema.']); */
            // session()->flash('error', "Subdomínio já cadastrado!");
            alert()->error('Este email já está um uso. Tente outro.');

            return redirect()->route('register.create');
        } else {
            // Mail::to( config('mail.from.address'))->send(new SendEmail($data));
            // dd($request->all());
            $tenant1 = Tenant::create([
                'id' => $request->domain,
                'nome' => $request->nome,
                'email' => $request->email,
                'endereco' => $request->endereco,
                'cidade' => $request->cidade,
                'telefone' => $request->telefone,
                'celular' => $request->celular,
                'password' => $request->password,
            ]);

            Tenant::all()->runForEach(function ($request) {
                $data['password'] = bcrypt($request->password);
                // dd($request->all());
                User::create([
                    'name' => $request->nome,
                    'email' => $request->email,
                    'password' => $data['password']]);
            });

            $tenant1->domains()->create([
                'domain' => $request->domain.'.localhost',
            ]);

            // dd($request->domain);

            if ($tenant1) {
                // alert()->success('Cadastro realizado com sucesso!');
                session()->flash('success', 'Enviamos um email para você com os detalhes de acesso!');

                return view('register.index');
                // return redirect('http://' . $request->domain . '.localhost:8989/login');

            }
        }
    }
}
