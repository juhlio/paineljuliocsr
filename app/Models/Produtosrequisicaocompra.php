<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produtosrequisicaocompra extends Model
{

    protected $fillable = [
        'idRequisicao',
        'produtoCadastrado',
        'produto',
        'descricao',
        'quantidade',
        'tipo',
    ];
    use HasFactory;
}
