<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

use App\Http\Controllers\AssinaturaController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\ServicosController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\LojaController;
use App\Http\Controllers\VitrineController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\WhatsappInstanceController;
use App\Http\Controllers\Public\PublicAgendamentoController;
use App\Http\Controllers\EmpresaController;


Route::middleware(['auth', 'trial'])->group(function () {

    Broadcast::routes(['middleware' => ['auth:sanctum']]);


// Rotas do Alcecar
Route::resource('agenda', AgendaController::class);


Route::prefix('financeiro')->group(function () {
    // Dashboard Geral
    Route::get('/', [FinanceiroController::class, 'index'])->name('financeiro.index');

    // Contas a Receber
    Route::get('/receber', [FinanceiroController::class, 'receber'])->name('financeiro.receber');
    
    // Contas a Pagar
    Route::get('/pagar', [FinanceiroController::class, 'pagar'])->name('financeiro.pagar');

    // Ações comuns
    Route::post('/store', [FinanceiroController::class, 'store'])->name('financeiro.store');
    Route::delete('/destroy/{id}', [FinanceiroController::class, 'destroy'])->name('financeiro.destroy');
});

Route::prefix('estoque')->group(function () {
    Route::get('/', [ProdutoController::class, 'index'])->name('estoque.index');
    Route::post('/store', [ProdutoController::class, 'store'])->name('estoque.store');
    Route::put('/update/{id}', [ProdutoController::class, 'update'])->name('estoque.update');
    Route::delete('/destroy/{id}', [ProdutoController::class, 'destroy'])->name('estoque.destroy');
});

Route::prefix('empresa')->group(function () {
    Route::get('/', [EmpresaController::class, 'index'])->name('empresa.index');
    Route::delete('/foto/delete/{id}', [EmpresaController::class, 'deleteFoto'])->name('empresa.foto.delete');
    Route::put('/update-galeria/{id}', [EmpresaController::class, 'updateGaleria'])->name('empresa.update.galeria');
    Route::put('/update/{id}', [EmpresaController::class, 'update'])->name('empresa.update');
});
Route::prefix('whatsapp')->group(function () {
    // Note que agora o NOME da rota de criação é 'whatsapp.store'
    Route::post('/create', [WhatsappInstanceController::class, 'store'])->name('whatsapp.store');
    
    // Rota de mensagens que adicionamos
    Route::post('/update-messages', [WhatsappInstanceController::class, 'updateMessages'])->name('whatsapp.update-messages');
    
    // ... as outras rotas seguem o mesmo padrão
    Route::get('/', [WhatsappInstanceController::class, 'index'])->name('whatsapp.index');
    Route::get('/connect/{name}', [WhatsappInstanceController::class, 'connect'])->name('whatsapp.connect');
    Route::get('/sync/{name}', [WhatsappInstanceController::class, 'syncStatus'])->name('whatsapp.sync');
    Route::post('/send-test', [WhatsappInstanceController::class, 'sendTest'])->name('whatsapp.send-test');
    Route::post('/logout/{name}', [WhatsappInstanceController::class, 'logout'])->name('whatsapp.logout');
    Route::delete('/delete/{id}', [WhatsappInstanceController::class, 'destroy'])->name('whatsapp.delete');
    Route::get('/connected-success', [WhatsappInstanceController::class, 'connectedSuccess'])->name('whatsapp.connected.success');
});

// Listagem das fotos
    Route::get('/galeria', [GaleriaController::class, 'index'])->name('galeria.index');
    
    // Processar upload
    Route::post('/galeria', [GaleriaController::class, 'store'])->name('galeria.store');
    
    // Remover foto
    Route::delete('/galeria/{galeria}', [GaleriaController::class, 'destroy'])->name('galeria.destroy');

Route::post('/agenda/concluir', [AgendaController::class, 'concluirAtendimento'])->name('agenda.concluir');
Route::get('profissional/{id}/horarios', [AgendaController::class, 'getHorariosProfissional']);
Route::get('api/agenda/eventos', [AgendaController::class, 'getEventos'])->name('agenda.api');
// Rota Principal de Funcionários (Resource)
    Route::resource('profissionais', ProfissionalController::class);

    Route::resource('servicos', ServicosController::class);

    Route::get('/gastos', [VeiculoGastoController::class, 'index'])->name('gastos.index');


    Route::post('/perfil/excluir', [PerfilController::class, 'deleteFiles']);
    Route::post('/perfil/excluir-pasta', [PerfilController::class, 'deleteFolders']);


    Route::get('/assinatura-expirada', function () {
        return view('assinatura.expirada');
    })->name('assinatura.expirada');

    Route::post('/create-pix-payment', [PaymentController::class, 'createPixPayment']);
    
    Route::get('/check-payment-status', function (Request $request) {
        $user = Auth::user();

        if (! $user) {
            Log::error('Usuário não autenticado ao verificar pagamento.');

            return response()->json(['status' => 'unauthorized'], 401);
        }

        $pedido = \App\Models\Assinatura::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $pedido) {
            Log::error("Nenhum pedido encontrado para o usuário ID {$user->id}");

            return response()->json(['status' => 'no_order_found']);
        }

        return response()->json(['status' => $pedido->status]);
    });

    Route::post('/checkout', [PaymentController::class, 'selecionarPlano'])->name('checkout');
    Route::get('/pagamento', [PaymentController::class, 'paginaPagamento'])->name('pagamento.index');

    Route::get('/assinatura', [AssinaturaController::class, 'index'])->name('assinatura.index');


    Route::get('/planos', [PaymentController::class, 'index'])->name('planos.index');

    Route::get('/pagamento-confirmado', function () {
        return view('pagamentos.sucesso'); // Retorna a view correta
    })->name('pagamento.confirmado');

    // Rota para a página de falha (quando o pagamento falhar)
    Route::get('/pagamento-falha', [PaymentController::class, 'paymentFailure'])->name('pagamentos.falha');

    // Rota para a página pendente (quando o pagamento ficar pendente)
    Route::get('/pagamento-pendente', [PaymentController::class, 'paymentPending'])->name('pagamentos.pendente');

    /* Route::delete('/users', [UserController::class, 'deleteAll'])->name('users.delete'); */
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

    // DASHBOARD
    Route::get('/dashboard', [DashController::class, 'index'])->name('dashboard.index');

    // PERFIL
    Route::put('/perfil/revenda/update', [PerfilController::class, 'updateRevenda'])->name('perfil.revenda.update');
    Route::put('/perfil/{id}', [PerfilController::class, 'update'])->name('perfil.update');
    Route::get('/perfil/{id}/edit', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');


    Route::put('/clientes/{id}', [ClientesController::class, 'update'])->name('clientes.update');
    Route::delete('/clientes/{id}', [ClientesController::class, 'destroy'])->name('clientes.destroy');
    Route::post('/clientes', [ClientesController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/create', [ClientesController::class, 'create'])->name('clientes.create');
    Route::get('/clientes/{id}/edit', [ClientesController::class, 'edit'])->name('clientes.edit');
    Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes.index');
    Route::get('/buscar-clientes', [ClientesController::class, 'buscarClientes']);
    Route::get('/clientes/{id}', [ClientesController::class, 'show'])->name('clientes.show');


});
// 1. Rotas Fixas primeiro
Route::get('/', [SiteController::class, 'index'])->name('site.index');
Route::get('/plano', [LojaController::class, 'planos'])->name('site.planos');

// 2. Esqueci a senha
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

// 3. Processamento do agendamento
Route::post('/agendamento/confirmar', [VitrineController::class, 'agendar'])->name('agendamento.publico.store');

// 4. Autenticação (Dashboard, etc)
require __DIR__.'/auth.php';
Route::get('profissional/{id}/horarios', [VitrineController::class, 'getHorariosProfissional']);
// 5. A ÚLTIMA: Vitrine (O slug precisa estar no fim para não interceptar as rotas acima)
Route::get('/{slug}', [VitrineController::class, 'show'])->name('vitrine.salao');