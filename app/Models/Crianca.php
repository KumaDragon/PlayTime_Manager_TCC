<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crianca extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','nascimento','cliente_id'
    ];

    protected $casts = [
        'nascimento' => 'datetime',
    ];
}
