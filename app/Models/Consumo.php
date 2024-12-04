<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Consumo extends Model
{
    use HasFactory;

    protected $fillable = [
        'crianca_id',
        'user_id',
        'cliente_id',
        'status',
        'valor_total',
        'tempo_total'
    ];

    public $timestamps = true;

    public function servicos()
    {
        return $this->belongsToMany(Servico::class, 'consumo_servico')->withTimestamps();
    }

    public function totalTempo()
    {
        $tempos = $this->servicos;
        $result = 0;
        foreach ($tempos as $tempo) {
            $result += $tempo->tempo;
        }
        return $result;
    }



    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }


    public function crianca()
    {
        return $this->belongsTo(Crianca::class);
    }

    public function tempo()
    {
        $tempoTotal = $this->totalTempo();  // Obter o tempo total dos serviços
    
        // Garantir que 'created_at' seja uma instância de Carbon e não seja nulo
        if ($this->created_at) {
            $criado = $this->created_at->copy(); // Cria um clone do valor original
        } else {
            $criado = Carbon::now(); // Inicializa com o horário atual
        }
    
        // Adicione os minutos ao valor de 'created_at'
        return $criado->addMinutes($tempoTotal);
    }
}
