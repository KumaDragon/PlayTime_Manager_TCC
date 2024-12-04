<?php

use App\Models\Consumo;
use App\Models\Servico;
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
        Schema::create('consumo_servico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumo_id')->constrained()->onDelete('cascade');
            
            $table->foreignId('servico_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumo_servico');
    }
};
