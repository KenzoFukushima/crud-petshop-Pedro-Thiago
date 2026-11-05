<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pet')->constrained('pets')->cascadeOnDelete();
            $table->foreignId('id_servico')->constrained('servicos')->cascadeOnDelete();
            $table->dateTime('data_hora');
            $table->string('status', 20)->default('agendado');
            $table->string('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
