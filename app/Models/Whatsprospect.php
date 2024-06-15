<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class whatsprospect extends Model
{

    protected $fillable =[
        'nomeContato',
        'telefone',
        'email',
        'nomeEmpresa',
        'cnjp',
        'razaoContato',
        'obs',
        'origem',
    ];
    use HasFactory;
}
