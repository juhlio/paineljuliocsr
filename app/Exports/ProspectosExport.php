<?php

namespace App\Exports;

use App\Models\Prospecto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ProspectosExport implements FromQuery
{
    use Exportable;

    public function __construct($cidade, $uf, $segmento)
    {
        $this->cidade = $cidade;
        $this->uf = $uf;
        $this->segmento = $segmento;
    }

    public function query()
    {
        return Prospecto::query()->where('cidade', '=', $this->cidade)->where('uf', '=', $this->uf )->where('segmento', '=', $this->segmento);
    }
}


