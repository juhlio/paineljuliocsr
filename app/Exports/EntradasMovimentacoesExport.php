<?php

namespace App\Exports;

use App\Models\Entrada;
use App\Models\Productscategorie;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;

class EntradasMovimentacoesExport implements FromView, WithTitle
{
    protected $dataInicial;
    protected $dataFinal;

    public function __construct($dataInicial, $dataFinal)
    {
        $this->dataInicial = $dataInicial;
        $this->dataFinal = $dataFinal;
    }


    public function view(): View
    {
        $iniData = $this->dataInicial;
        $dataFormatada = date_create_from_format('dmY', $iniData); // 'd' para dia, 'm' para mês, 'Y' para ano
        $iniDataFormat = date_format($dataFormatada, 'Y-m-d');

        $fimData = $this->dataFinal;
        $dataFormatada = date_create_from_format('dmY', $fimData); // 'd' para dia, 'm' para mês, 'Y' para ano
        $fimDataFormat = date_format($dataFormatada, 'Y-m-d');


        $detalhesEntradas = Entrada::select()
            ->join('produtos', 'entradas.idConsumiveis', '=', 'produtos.id')
            ->whereBetween('entradas.created_at', [$iniDataFormat, $fimDataFormat])
            ->get();

        foreach ($detalhesEntradas as $entrada) {

            if ($entrada->novo == 1) {
                $entrada->estado = 'NOVO';
            } else if ($entrada->novo == 0) {
                $entrada->estado = 'USADO';
            }

            $nomeCategoria = Productscategorie::select('descricao')->where('id', $entrada->idTipo)->first();
            $entrada->nomeCategoria = $nomeCategoria->descricao;

        }


        return view('Exports.movimentacoesentradas', [
            'entradas' => $detalhesEntradas,
        ]);
    }

    public function title(): string
    {
        return 'ENTRADAS'; // Defina o nome da aba desejado aqui
    }
}
