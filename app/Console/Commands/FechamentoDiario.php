<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;

use App\Models\Produto;
use App\Models\Entrada;
use App\Models\Saida;
use App\Models\Estoquefechamento;

class FechamentoDiario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:fechamento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $produtos = Produto::select()
            ->get();

        $totalEmEstoque = 0;

        foreach ($produtos as $produto) {


            $entradas = Entrada::select()
                ->where('idConsumiveis', $produto->id)
                ->sum('quantidade');

            $saidas = Saida::select()
                ->where('idConsumiveis', $produto->id)
                ->sum('quantidade');

            $totalEstoque = $entradas - $saidas;


            if ($totalEstoque > 0) {


                $ultimaEntrada = Entrada::select()
                    ->where('idConsumiveis', $produto->id)
                    ->orderBy('id', 'desc')
                    ->first();



                $custoTotalProduto = $totalEstoque * $ultimaEntrada->custo;

                $totalEmEstoque = $totalEmEstoque + $custoTotalProduto;
            }
        }

        $fechamento = new Estoquefechamento();
        $fechamento->valor = $totalEmEstoque;
        $fechamento->save();
    }
}
