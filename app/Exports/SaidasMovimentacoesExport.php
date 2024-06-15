<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Saida;
use App\Models\Productscategorie;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;

class SaidasMovimentacoesExport implements FromView, WithTitle
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
        $dataFormatada = date_create_from_format('dmY', $iniData); 
        $iniDataFormat = date_format($dataFormatada, 'Y-m-d');

        $fimData = $this->dataFinal;
        $dataFormatada = date_create_from_format('dmY', $fimData); 
        $fimDataFormat = date_format($dataFormatada, 'Y-m-d');

        $saidas = Saida::select()
            ->join('produtos', 'saidas.idConsumiveis', '=', 'produtos.id')
            ->whereBetween('saidas.created_at', [$iniDataFormat, $fimDataFormat])
            ->get();

        foreach ($saidas as $saida) {
            if ($saida->estado == 1) {
                $saida->estado = 'NOVO';
            } else if ($saida->estado == 2) {
                $saida->estado = 'USADO';
            }

            $nomeCategoria = Productscategorie::select('descricao')->where('id', $saida->idTipo)->first();
            $saida->nomeCategoria = $nomeCategoria->descricao;
        }


        return view('Exports.movimentacoessaidas', [
            'saidas' => $saidas,
        ]);
    }

    public function title(): string
    {
        return 'SAIDAS'; // Defina o nome da aba desejado aqui
    }
}
