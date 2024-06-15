<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enelcall extends Model
{
    protected $fillable =[
        'os',
        'cliente',
        'dataChamado',
        'endereco',
        'tipo',
        'potencia',
        'dataAtendimento',
    ];
    use HasFactory;
}
