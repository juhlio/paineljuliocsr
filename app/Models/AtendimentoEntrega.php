<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtendimentoEntrega extends Model
{
    use HasFactory;

    protected $table = 'atendimentoentregas';

    protected $fillable = [
        'id_maquina',
        'fabricante_motor',
        'modelo_motor',
        'serie_motor',
        'fabricante_alternador',
        'modelo_alternador',
        'serie_alternador',
        'cliente',
        'data',
        'endereco',
        'responsavel_entrega',
        'recebido_por',
        'caminhao',
        'tamanho_equipe',
        'abastecimento',
        'nf',
    ];

    protected $casts = [
        'data' => 'datetime:d-m-Y H:i',
    ];

    public function maquina()
    {
        return $this->belongsTo(Maquina::class, 'id_maquina');
    }
}
