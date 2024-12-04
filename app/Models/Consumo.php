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
    return $this->servicos->sum('tempo');
    }




    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }


    public function crianca()
    {
    return $this->belongsTo(Crianca::class, 'crianca_id');
    }


    public function tempo()
    {
        $tempoTotal = $this->totalTempo(); // Obter o tempo total dos serviços
        $criado = $this->created_at ? Carbon::parse($this->created_at) : Carbon::now(); // Usa 'created_at' ou o horário atual
        return $criado->addMinutes($tempoTotal); // Soma o tempo total ao created_at (ou horário atual)
    }
    

}
