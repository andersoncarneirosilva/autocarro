<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('cpf')->unique()->nullable(); // Nullable pois o cliente final pode não querer dar o CPF de cara
    $table->string('rg')->unique()->nullable();
    $table->string('telefone')->nullable();
    
    // Nível de acesso: 'admin', 'salao', 'cliente'
    $table->string('nivel_acesso')->default('cliente'); 
    
    $table->string('password');
    $table->string('image')->nullable();
    $table->string('status')->nullable(); // ativo, inativo, suspenso
    
    // Campos específicos para o Dono do Salão (SaaS)
    $table->string('plano')->nullable(); // bronze, prata, ouro
    $table->string('payment_status')->nullable(); // paid, unpaid, trial
    $table->decimal('credito', 10, 2)->default(0.00);
    
    $table->timestamp('last_login_at')->nullable();
    $table->timestamp('password_changed_at')->nullable();
    $table->timestamp('email_verified_at')->nullable();
    
    // AJUSTE AQUI: O id da empresa (Salão) à qual este usuário pertence
    // Se for NULL, ele é um "Cliente Final" que pode agendar em qualquer lugar
    $table->foreignId('empresa_id')->nullable()->constrained('empresas')->onDelete('cascade');
    
    $table->rememberToken();
    $table->timestamps();
});
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
