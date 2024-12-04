<?php

use App\Models\Cliente;
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
        Schema::create('consumos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained();

            $table->foreignId('crianca_id')->constrained();

            $table->foreignId('user_id')->constrained();

            $table->tinyInteger('pago')->default(0);

            $table->integer('tempo_total')->default(0); // Tempo total (em minutos)
            
            $table->decimal('valor_total', 10, 2)->default(0); // Valor total dos serviços
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumos');
    }
};
