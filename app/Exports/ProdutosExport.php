<?php

namespace App\Exports;

use App\Models\Produto;
use App\Models\Entrada;
use App\Models\Saida;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProdutosExport implements FromView
{
    public function view(): View
    {

        $produtos = Produto::select()
            ->get();

        foreach ($produtos as $produto) {


            $entradas = Entrada::select()
                ->where('idConsumiveis', $produto->id)
                ->sum('quantidade');

            $saidas = Saida::select()
                ->where('idConsumiveis', $produto->id)
                ->sum('quantidade');

            $totalEstoque = $entradas - $saidas;
            $produto->totalEstoque = $totalEstoque;

            if ($totalEstoque !== null) {


                $ultimaEntrada = Entrada::select()
                    ->where('idConsumiveis', $produto->id)
                    ->orderBy('id', 'desc')
                    ->first();

                if (is_null($ultimaEntrada)) {
                    $produto->ultimoCusto = 0;
                    $produto->custoTotal = 0;
                } else {
                    $produto->ultimoCusto = $ultimaEntrada->custo;
                    $custoTotalProduto = $totalEstoque * $ultimaEntrada->custo;
                }
            }
        }


        return view('Exports.estoque', [
            'produtos' => $produtos,
        ]);
    }
}
