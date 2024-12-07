<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'telefone'
    ];

    public function criancas()
    {
        return $this->hasMany(Crianca::class);
    }    

    public function consumos()
    {
        return $this->hasMany(Consumo::class);
    }

    public function index()
    {
    // Buscando todos os clientes do banco de dados
    $clientes = Cliente::all();

    // Retornando a view com os clientes
    return view('clientes.index', compact('clientes'));
    }
}
