<?php

namespace App\Http\Controllers;

use App\Models\DashModel;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Tenant;
use App\Models\User;
use App\Mail\SendEmailTenant;
use Mail;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    //
    protected $model;

    public function __construct(Tenant $comp)
    {
        $this->model = $comp;
    }

    public function index(Request $request){

        $companies = Tenant::all();

        return view('site.index', compact('companies'));
    }

    public function create(){
        //$companies = Tenant::all();
        return view('register.create');
    }

    public function store(Request $request)
{
    // Validar os dados recebidos
    //dd($request);
    try {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'telefone' => 'required|string|max:15', 
            'password' => 'required|string|min:6|confirmed',
            'image'    => 'nullable|image|max:1024', // Validar imagem (opcional)
            'database' => 'required|string|max:255',
        ]);
        //dd($validated);
    } catch (\Illuminate\Validation\ValidationException $e) {
        dd($e->errors());
    }

    // Criar o tenant
    $tenant = $this->createTenant($validated);
    //dd($tenant);
    // Criar o domínio do tenant
    try {
        $tenant->domains()->create([
            'domain' => $validated['database'] . ".localhost",
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 400);
    }

    // Criar o usuário no banco de dados do tenant
    User::on('tenant')->create([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'telefone' => $validated['telefone'],
        'perfil'   => "Usuário",
        'password' => bcrypt($validated['password']),
        'classe'   => "badge badge-outline-success",
        'status'   => "Ativo",
        'credito'  => "10",
    ]);
    
    //Mail::to( config('mail.from.address'))->send(new SendEmailTenant($validated));
    alert()->success('Tenant criado com sucesso!');
    return redirect()->route('site.index');
}



public function createTenant($tenantData)
{
    //dd($tenantData);
    $tenant = Tenant::create([  
        'id' => $tenantData['database'], 
        'name' => $tenantData['name'],   
        'email' => $tenantData['email'], 
        'password' => bcrypt($tenantData['password']),
    ]);

   
//dd($tenant);
    $this->migrateTenantDatabase($tenant);
    
    return $tenant;
}



    

        protected function migrateTenantDatabase($tenant)
        {
            // Alterar a configuração de conexão para o banco do tenant
            //dd($tenant->tenancy_db_name);
            config([
                'database.connections.tenant' => [
                    'driver' => 'mysql',
                    'host' => env('DB_HOST'),
                    'port' => env('DB_PORT'),
                    'database' => $tenant->tenancy_db_name,
                    'username' => env('DB_USERNAME'),
                    'password' => env('DB_PASSWORD'),
                ],
            ]);

            // Executar migrações no banco de dados do tenant
            \Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path' => 'database/migrations/tenant',
                '--force' => true,
            ]);
        }




}
