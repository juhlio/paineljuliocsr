<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisicaocompra extends Model
{
    protected $fillable = [
        'idCliente',
        'tipo',
        'data',
        'solicitante',
        'status',
    ];
    use HasFactory;
}
