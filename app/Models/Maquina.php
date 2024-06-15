<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{


    protected $fillable = [
        'nf',
        'valorNota',
        'dataNota',
        'empresaCompra',
        'classificacaoFiscal',
        'tipoEquipamento',
        'fabricanteEquipamento',
        'serieEquipamento',
        'potencia',
        'dataFabricacao',
        'fabricanteMotor',
        'modeloMotor',
        'serieMotor',
        'fabricanteAlternador',
        'modeloAlternador',
        'serieAlternador',
        'quantidadeOleo',
        'modeloFiltroCombustivel',
        'quantidadeFiltroCombustivel',
        'modeloFiltroSeparador',
        'quantidadeFiltroSeparador',
        'modeloFiltroAgua',
        'quantidadeFiltroAgua',
        'modeloFiltroOleo',
        'quantidadeFiltroOleo',
        'modeloFiltroAr',
        'quantidadeFiltroAr',
        'fabricanteModulo',
        'modeloModulo'
    ];

    use HasFactory;
}
