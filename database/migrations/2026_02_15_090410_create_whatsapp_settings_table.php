<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            
            // Status de ativação
            $table->boolean('confirmation_is_active')->default(true);
            $table->boolean('cancellation_is_active')->default(false);
            $table->boolean('reminder_is_active')->default(false);
            $table->boolean('bot_is_active')->default(false);
            
            // Templates de mensagens
            $table->text('confirmation_template')->nullable();
            $table->text('cancellation_template')->nullable();
            $table->text('reminder_template')->nullable();
            $table->text('bot_template')->nullable();
            
            // Configurações de tempo
            $table->integer('reminder_time')->default(1440); // minutos (24h)
            $table->integer('bot_cooldown')->default(3600);   // segundos (1h)
            
            $table->timestamps();

            // Relacionamento com a empresa
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_settings');
    }
};