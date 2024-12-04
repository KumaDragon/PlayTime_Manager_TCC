<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'valor',
        'tempo'
    ];

    protected $casts = [
        'valor' => 'float',
        'tempo' => 'integer',
    ];

    // Modelo Servico
    public function consumos()
    {
        return $this->belongsToMany(Consumo::class, 'consumo_servico')->withTimestamps();
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(strtolower($value));
    }
    

}
