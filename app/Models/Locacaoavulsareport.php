<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locacaoavulsareport extends Model
{
    use HasFactory;

    protected $fillable = [
        'idEquip',
        'cliente',
        'endereco',
        'tipoConexao',
        'caminhao',
        'seccaoCondutorTransportado',
        'lancesPorFaseTransportado',
        'lancesNeutroTransportado',
        'seccaoCondutorUtilizado',
        'lancesPorFaseUtilizado',
        'lancesNeutroUtilizado',
        'horimetroInicial',
        'horimetroFinal',
        'kwhInicial',
        'kwhFinal',
        'chegadaGmg',
        'inicioOperacao',
        'terminoOperacao',
        'obs',
        'statusRelatorio'
    ];
}
