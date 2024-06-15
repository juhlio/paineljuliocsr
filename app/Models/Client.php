<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable =[
        'razaoSocial',
        'nome',
        'cnpj',
        'cnpjFormatado',
        'classificacao',
        'telefone',
        'cep',
        'endereco',
        'bairro',
        'cidade',
        'uf',
        'email',
        'emailCobranca',
        'idAuvo',

    ];

    use HasFactory;
}
