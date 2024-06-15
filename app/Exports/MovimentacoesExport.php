<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;


class MovimentacoesExport implements WithMultipleSheets
{
    use Exportable;

    protected $dataInicial;
    protected $dataFinal;

    public function __construct($dataInicial, $dataFinal)
    {
        $this->dataInicial = $dataInicial;
        $this->dataFinal = $dataFinal;
    }


    public function sheets(): array
    {
        $sheets = [];

        // Adicione a primeira aba (você já a tinha implementado)
        $sheets[] = new EntradasMovimentacoesExport($this->dataInicial, $this->dataFinal);

        // Adicione uma nova aba
        $sheets[] = new SaidasMovimentacoesExport($this->dataInicial, $this->dataFinal); 

        return $sheets;
    }
}
