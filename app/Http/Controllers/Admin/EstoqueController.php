<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\Imagemproduto;
use App\Models\Entrada;
use App\Models\Saida;
//use App\Models\Client;
use App\Models\Estoquefechamento;
use App\Models\Productscategorie;
use Illuminate\Support\Facades\Http;
use App\Exports\ProdutosExport;
use App\Exports\MovimentacoesExport;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');

    }


    public function index()
    {
        $produtos = Produto::select()
            ->get();


        $totalEmEstoque = 0;

        $totalEntradas = Entrada::select()
            ->sum('quantidade');

        $totalSaidas = Saida::select()
            ->sum('quantidade');

        $totalProdutosEstoque = $totalEntradas - $totalSaidas;


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
                    $custoTotalProduto = 0;
                } else {
                    $custoTotalProduto = $totalEstoque * $ultimaEntrada->custo;
                }

                $totalEmEstoque = $totalEmEstoque + $custoTotalProduto;
            }
        }

        $totalEmEstoque = floatval($totalEmEstoque);
        $totalEmEstoque = number_format($totalEmEstoque, 2, ',', '.');

        return view('Estoque.home', [
            'produtos' => $produtos,
            'totalEmEstoque' => $totalEmEstoque,
            'totalProdutosEstoque' => $totalProdutosEstoque,
        ]);
    }

    public function novoProduto()
    {
        return view('Estoque.novoproduto');
    }

    public function criaProduto()
    {
        $descricao = filter_input(INPUT_POST, 'descricao');
        $fabricante = filter_input(INPUT_POST, 'fabricante');
        $t = filter_input(INPUT_POST, 'tipo');

        if (strpos($t, '-') !== false) {
            $tipo = explode(" - ", $t);
            $idTipo = $tipo[0];
            $tipo = $tipo[1];
        } else {

            $cat = new ProductsCategorie();
            $cat->descricao = $t;
            $cat->save();

            $idCat = ProductsCategorie::select()
                ->orderBy('created_at', 'desc')
                ->first();

            $idTipo = $idCat->id;
            //requisição para api auvo
            $client = new Client();
            //$response = $client->get("https://apiessencial.com.br/auvoapp/sendsinglecategory/" . $idTipo . "/");
            $tipo = $idTipo;
            sleep(3);
        }



        $codFabricante = filter_input(INPUT_POST, 'codFabricante');
        $codEan = filter_input(INPUT_POST, 'codEan');
        $ncm = filter_input(INPUT_POST, 'ncm');
        $unidadeMedida = filter_input(INPUT_POST, 'unidadeMedida');
        $localizacao = filter_input(INPUT_POST, 'localizacao');

        $produto = new Produto();
        $produto->descricao = $descricao;
        $produto->fabricante = $fabricante;
        $produto->idTipo = $idTipo;
        $produto->tipo = $tipo;
        $produto->codFabricante = $codFabricante;
        $produto->codEan = $codEan;
        $produto->ncm = $ncm;
        $produto->unidadeMedida = $unidadeMedida;
        $produto->localizacao = $localizacao;
        $produto->save();

        $criado = Produto::select()
            ->orderBy('created_at', 'desc')
            ->first();

        //requisição para api auvo
        $client = new Client();
        //$response = $client->get("https://apiessencial.com.br/auvoapp/newproduct/" . $criado->id . "/");
        //colocar uma espera de 5 segundos
        sleep(3);



        if ($_FILES['foto']['name']) {

            $foto = new ImagemProduto();
            $nomefotocapa = $criado->id . '_produto_' . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/products/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['foto']['tmp_name'], $nomefotocapacompleto);








            //salva no banco de dados
            $foto->idProduto = $criado->id;
            $foto->url = $nomefotocapa;
            $foto->save();


        }

        //requisição para api rd station
        $client = new Client();
        //$response = $client->get("https://apiessencial.com.br/rd/sendsingleproduct/" . $criado->id . "/");







        return redirect()->route('detalheproduto', $criado->id)->with('success', 'Atualizado.');
    }

    public function detalheProduto($id)
    {


        $produto = Produto::select()
            ->where('id', $id)
            ->first();

        $entradas = Entrada::select()
            ->where('idConsumiveis', $id)
            ->sum('quantidade');

        $saidas = Saida::select()
            ->where('idConsumiveis', $id)
            ->sum('quantidade');

        $total = $entradas - $saidas;

        $entradasNovos = Entrada::select()
            ->where('idConsumiveis', $id)
            ->where('novo', '1')
            ->sum('quantidade');


        $saidasNovos = Saida::select()
            ->where('idConsumiveis', $id)
            ->where('estado', '1')
            ->sum('quantidade');

        $totalNovos = $entradasNovos - $saidasNovos;

        $entradasUsados = Entrada::select()
            ->where('idConsumiveis', $id)
            ->where('novo', '0')
            ->sum('quantidade');

        $saidasUsados = Saida::select()
            ->where('idConsumiveis', $id)
            ->where('estado', '0')
            ->sum('quantidade');

        $totalUsados = $entradasUsados - $saidasUsados;

        $detalhesEntradas = Entrada::select()
            ->where('idConsumiveis', $id)
            ->get();

        $detalhesSaidas = Saida::select()
            ->where('idConsumiveis', $id)
            ->get();

        $foto = ImagemProduto::select()
            ->where('idProduto', $id)
            ->first();



        return view('Estoque.detalheproduto', [
            'produto' => $produto,
            'foto' => $foto,
            'total' => $total,
            'totalNovos' => $totalNovos,
            'totalUsados' => $totalUsados,
            'detalhesEntradas' => $detalhesEntradas,
            'detalhesSaidas' => $detalhesSaidas,
            'id' => $id,

        ]);
    }

    public function alteraProduto($id)
    {

        $produto = Produto::select()
            ->where('id', $id)
            ->first();

        return view(
            'Estoque.alteraproduto',
            ['produto' => $produto]
        );
    }

    public function salvaAlteracaoProduto($id)
    {

        $produto = Produto::select()
            ->where('id', $id)
            ->first();

        $descricao = filter_input(INPUT_POST, 'descricao');
        $fabricante = filter_input(INPUT_POST, 'fabricante');
        $tipo = filter_input(INPUT_POST, 'tipo');
        $codFabricante = filter_input(INPUT_POST, 'codFabricante');
        $codEan = filter_input(INPUT_POST, 'codEan');
        $ncm = filter_input(INPUT_POST, 'ncm');
        $unidadeMedida = filter_input(INPUT_POST, 'unidadeMedida');
        $localizacao = filter_input(INPUT_POST, 'localizacao');

        $produto->descricao = $descricao;
        $produto->fabricante = $fabricante;
        $produto->tipo = $tipo;
        $produto->codFabricante = $codFabricante;
        $produto->codEan = $codEan;
        $produto->ncm = $ncm;
        $produto->unidadeMedida = $unidadeMedida;
        $produto->localizacao = $localizacao;
        $produto->save();

        try {
            $client = new Client();
            //$response = $client->get("https://apiessencial.com.br/auvoapp/updateproduct/" . $id . "/");
            // Trate a resposta, se necessário
        } catch (RequestException $e) {
            // Lida com erros de requisição
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
                $reasonPhrase = $response->getReasonPhrase();
                // Faça o tratamento adequado do erro
            }
        }


        return redirect()->route('detalheproduto', $id)->with('success', 'Atualizado.');
    }

    public function alteracaoimagem($id)
    {

        return view('Estoque.alteraimagem');
    }

    public function processaimagem($id)
    {
        $image = Imagemproduto::select()->where('id', $id)->first();

        $nomefotocapa = $image->idProduto . '_produto_' . date('dmYHis') . '.jpeg';
        $diretorio = "assets/images/products/";
        $nomefotocapacompleto = $diretorio . $nomefotocapa;
        move_uploaded_file($_FILES['foto']['tmp_name'], $nomefotocapacompleto);

        $image->url = $nomefotocapa;
        $image->save();

        return redirect()->route('detalheproduto', $image->idProduto)->with('success', 'Atualizado.');
    }

    public function entradaProduto($id)
    {

        $produto = Produto::select()
            ->where('id', $id)
            ->first();

        return view('Estoque.entradaproduto', [
            'produto' => $produto,
        ]);
    }

    public function processaEntrada($id)
    {

        if (filter_input(INPUT_POST, 'estadoProduto') === "Novo") {
            $novo = 1;
        } else {
            $novo = 0;
        }

        if (filter_input(INPUT_POST, 'tipoEntrada') === "Compra") {
            $tipoEntrada = 1;
        } else if (filter_input(INPUT_POST, 'tipoEntrada') === "Devolução") {
            $tipoEntrada = 2;
        } else if (filter_input(INPUT_POST, 'tipoEntrada') === "Retorno de Obra") {
            $tipoEntrada = 3;
        }


        $idConsumiveis = $id;
        $cliente = filter_input(INPUT_POST, 'cliente');
        $nf = filter_input(INPUT_POST, 'nf');
        $custo = filter_input(INPUT_POST, 'custo');
        $quantidade = filter_input(INPUT_POST, 'quantidade');
        $data = filter_input(INPUT_POST, 'datetimepicker');

        $custo = str_replace(",", ".", $custo);

        $entrada = new Entrada();
        $entrada->idConsumiveis = $idConsumiveis;
        $entrada->fornecedor = $cliente;
        $entrada->nf = $nf;
        $entrada->novo = $novo;
        $entrada->tipoEntrada = $tipoEntrada;
        $entrada->custo = $custo;
        $entrada->quantidade = $quantidade;
        $entrada->data = $data;
        $entrada->save();

        /* $client = new Client();
        $response = $client->get("https://apiessencial.com.br/auvoapp/syncstock/" . $id . "/"); */

        return redirect()->route('detalheproduto', $id)->with('success', 'Atualizado.');
    }

    public function saidaProduto($id)
    {

        $produto = Produto::select()
            ->where('id', $id)
            ->first();

        return view('Estoque.saidaproduto', [
            'produto' => $produto,
        ]);
    }

    public function processaSaida($id)
    {
        if (filter_input(INPUT_POST, 'estadoProduto') === "Novo") {
            $novo = 1;
        } else {
            $novo = 0;
        }

        $uc = Entrada::select()
            ->where('idConsumiveis', $id)
            ->orderBy('id', 'desc')
            ->first();

        $ultimoCusto = $uc->custo;


        $idConsumiveis = $id;
        $quantidade = filter_input(INPUT_POST, 'quantidade');
        $data = filter_input(INPUT_POST, 'datetimepicker');
        $cliente = filter_input(INPUT_POST, 'cliente');
        $idCliente = explode(" - ", $cliente);
        $idCliente = $idCliente[0];
        $solicitante = filter_input(INPUT_POST, 'solicitante');




        $saida = new Saida();
        $saida->idConsumiveis = $idConsumiveis;
        $saida->quantidade = $quantidade;
        $saida->estado = $novo;
        $saida->custo = $ultimoCusto;
        $saida->data = $data;
        $saida->cliente = $cliente;
        $saida->idCliente = $idCliente;
        $saida->solicitante = $solicitante;
        $saida->save();

        $client = new Client();
        //$response = $client->get("https://apiessencial.com.br/auvoapp/syncstock/" . $id . "/");


        return redirect()->route('detalheproduto', $id)->with('success', 'Atualizado.');
    }

    public function telaTotalEstoque()
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



        return view('Estoque.total', [
            'totalEmEstoque' => $totalEmEstoque,
        ]);
    }

    public function exportaProdutos()
    {
        return Excel::download(new ProdutosExport, 'estoque.xlsx');
    }

    public function fechamentoDiario()
    {
        $produtos = Produto::select()
            ->get();

        $totalEmEstoque = 0;

        $totalEntradas = Entrada::select()
            ->sum('quantidade');

        $totalSaidas = Saida::select()
            ->sum('quantidade');

        $totalProdutosEstoque = $totalEntradas - $totalSaidas;

        foreach ($produtos as $produto) {



            $entradas = Entrada::select()
                ->where('idConsumiveis', $produto->id)
                ->sum('quantidade');

            $saidas = Saida::select()
                ->where('idConsumiveis', $produto->id)
                ->sum('quantidade');

            $totalEstoque = $entradas - $saidas;


            if ($totalEstoque !== null) {


                $ultimaEntrada = Entrada::select()
                    ->where('idConsumiveis', $produto->id)
                    ->orderBy('id', 'desc')
                    ->first();

                if (is_null($ultimaEntrada)) {
                    $custoTotalProduto = 0;
                } else {
                    $custoTotalProduto = $totalEstoque * $ultimaEntrada->custo;
                }

                $totalEmEstoque = $totalEmEstoque + $custoTotalProduto;
            }
        }

        $fechamento = new Estoquefechamento();
        $fechamento->valor = $totalEmEstoque;
        $fechamento->totalProdutos = $totalProdutosEstoque;
        $fechamento->save();
    }

    public function telamovimentacoes()
    {

        $si = Estoquefechamento::select()
            ->orderBy('id', 'desc')
            ->first();

        $saldoInicial = floatval($si->valor);
        $saldoInicial = number_format($saldoInicial, 2, ',', '.');


        $detalhesEntradas = Entrada::select()
            ->join('produtos', 'entradas.idConsumiveis', '=', 'produtos.id')
            ->get();

        $saidas = Saida::select()
            ->join('produtos', 'saidas.idConsumiveis', '=', 'produtos.id')
            ->get();

        $totalEntradas = 0;

        foreach ($detalhesEntradas as $entradas) {

            $custoEntrada = $entradas->custo * $entradas->quantidade;
            $totalEntradas = $totalEntradas + $custoEntrada;
        }

        $totalEntradas = floatval($totalEntradas);
        $totalEntradas = number_format($totalEntradas, 2, ',', '.');

        $totalSaidas = 0;

        foreach ($saidas as $saida) {

            $custoUltimaEntrada = Entrada::select('custo')
                ->where('idConsumiveis', $saida->idConsumiveis)
                ->orderBy('id', 'desc')
                ->first();


            $custoSaida = $custoUltimaEntrada->custo * $saida->quantidade;
            $totalSaidas = $totalSaidas + $custoSaida;
        }

        $totalSaidas = floatval($totalSaidas);
        $totalSaidas = number_format($totalSaidas, 2, ',', '.');

        $saldo = floatval($totalEntradas) - floatval($totalSaidas);
        $saldo = number_format($saldo, 2, ',', '.');

        $totalFinal = floatval($saldoInicial) + floatval($saldo);
        $totalFinal = number_format($totalFinal, 2, ',', ',');

        $dataInicio = '01082023';
        $dataFim = '17082023';


        return view('Estoque.movimentacoes', [
            'entradas' => $detalhesEntradas,
            'saidas' => $saidas,
            'totalEntradas' => $totalEntradas,
            'totalSaidas' => $totalSaidas,
            'saldo' => $saldo,
            'saldoInicial' => $saldoInicial,
            'totalFinal' => $totalFinal,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim
        ]);
    }

    public function atualizaMovimentacoes(Request $request)
    {
        $inicio = $request->input('dataInicio');
        $fim = $request->input('dataFim');

        $dataInicio = explode('/', $inicio);
        $dataInicio = $dataInicio[2] . '-' . $dataInicio[1] . '-' . $dataInicio[0];

        $dataFim = explode('/', $fim);
        $dataFim = $dataFim[2] . '-' . $dataFim[1] . '-' . $dataFim[0];


        // Faça as consultas necessárias para obter as informações a serem exibidas na página
        $entradas = Entrada::select()
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->get();

        $totalEntradas = 0;

        foreach ($entradas as $entrada) {

            $custoEntrada = $entrada->custo * $entrada->quantidade;
            $totalEntradas = $totalEntradas + $custoEntrada;
        }


        $saidas = Saida::select()
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->get();

        $totalSaidas = 0;

        foreach ($saidas as $saida) {

            $custoSaida = $saida->custo * $saida->quantidade;
            $totalSaidas = $totalSaidas + $custoSaida;
        }

        $saldo = $totalEntradas - $totalSaidas;

        $da = strtotime($dataInicio) - 1;
        $dataAnterior = date("Y-m-d", $da);

        $saldoInicial = Estoquefechamento::select()
            ->whereDate('created_at', $dataAnterior)
            ->first();

        if ($saldoInicial) {
            $saldoInicial = $saldoInicial->valor;
        } else {
            $saldoInicial = 0;
        }


        $detalhesEntradas = Entrada::select()
            ->join('produtos', 'entradas.idConsumiveis', '=', 'produtos.id')
            ->whereBetween('entradas.created_at', [$dataInicio, $dataFim])
            ->get();


        $saldoFinal = $saldoInicial + $saldo;

        $detalhesSaidas = Saida::select()
            ->join('produtos', 'saidas.idConsumiveis', '=', 'produtos.id')
            ->whereBetween('saidas.created_at', [$dataInicio, $dataFim])
            ->get();

        $saldoInicial = floatval($saldoInicial);
        $saldoInicial = number_format($saldoInicial, 2, ',', '.');

        $totalEntradas = floatval($totalEntradas);
        $totalEntradas = number_format($totalEntradas, 2, ',', '.');

        $totalSaidas = floatval($totalSaidas);
        $totalSaidas = number_format($totalSaidas, 2, ',', '.');

        $saldo = floatval($saldo);
        $saldo = number_format($saldo, 2, ',', '.');

        $saldoFinal = floatval($saldoFinal);
        $saldoFinal = number_format($saldoFinal, 2, ',', '.');



        return response()->json([
            'saldoInicial' => $saldoInicial,
            'totalEntradas' => $totalEntradas,
            'totalSaidas' => $totalSaidas,
            'saldo' => $saldo,
            'entradas' => $dataInicio,
            'saidas' => $dataFim,
            'detalhesEntradas' => $detalhesEntradas,
            'detalhesSaidas' => $detalhesSaidas,
            'saldoFinal' => $saldoFinal,

        ]);
    }

    public function telaEntradaXml()
    {

        return view('Estoque.entradaXml');
    }

    public function processaEntradaXml()
    {

        $extensaofoto1 = strtolower(substr($_FILES['xml']['name'], -5));
        $nomefoto1 = "foto1_" . "_" . md5(time()) . $extensaofoto1;
        $diretorio = "up/";
        move_uploaded_file($_FILES['xml']['tmp_name'], $diretorio . $nomefoto1);

        $arquivo = $diretorio . $nomefoto1;

        $xml = simplexml_load_file($diretorio . $nomefoto1);

        $fornecedor = $xml->NFe->infNFe->emit->xNome;
        $nf = $xml->NFe->infNFe->ide->nNF;


        $produtos = array();

        foreach ($xml->NFe->infNFe->det as $key => $xml) {
            $codigoproduto = "" . $xml->prod->cProd . "";
            $descricao = "" . $xml->prod->xProd . "";
            $ncm = "" . $xml->prod->NCM . "";
            $custo = "" . $xml->prod->vUnCom . "";
            $quantidade = "" . $xml->prod->qCom . "";
            $codean = "" . $xml->prod->cEAN;

            $produto = new Produto();
            $produto->codigo = $codigoproduto;
            $produto->descricao = $descricao;
            $produto->ncm = $ncm;
            $produto->custo = $custo;
            $produto->quantidade = $quantidade;
            $produto->ean = $codean;

            array_push($produtos, $produto);
        }

        unlink($arquivo);

        return (view('Estoque.insereEstoqueXml', [
            'produtos' => $produtos,
            'fornecedor' => $fornecedor,
            'nf' => $nf,
        ]));
    }

    public function listaProdutos()
    {


        $produtos = Produto::select('descricao', 'id')->get();

        foreach ($produtos as $row) {
            $data[] = array(

                'name' => $row["id"] . ' - ' . $row['descricao'],


            );
        }

        echo json_encode($data);
    }

    public function finalizaEntradaXml(Request $request)
    {

        $produtos = $request->input('produto');
        $i = 0;
        $t = count($produtos) - 1;

        while ($i <= $t) {

            $p = $request->input('produto')[$i];
            $produto = explode(" - ", $p);
            $idProduto = $produto[0];

            $entrada = new Entrada();
            $entrada->idConsumiveis = $idProduto;
            $entrada->fornecedor = $request->input('fornecedor')[$i];
            $entrada->nf = $request->input('nf')[$i];
            $entrada->custo = $request->input('custo')[$i];
            $entrada->quantidade = $request->input('quantidade')[$i];
            $entrada->novo = 1;
            $entrada->tipoEntrada = 1;
            $entrada->data = date('d/m/Y');
            $entrada->save();


            $i++;
        }

        return redirect()->route('homeestoque')->with('success', 'Atualizado.');
    }

    public function telaFechamentoDiario()
    {
        $fechamentos = Estoquefechamento::orderByDesc('created_at')->limit(30)->get();

        return view('Estoque.telafechamentodiario', [
            'fechamentos' => $fechamentos,
        ]);
    }

    public function telaRetorno()
    {

        return view('Estoque.telaretorno');
    }

    public function listaCategoriasProdutos()
    {

        $categorias = Productscategorie::select()->get();

        foreach ($categorias as $categoria) {
            $data[] = array(

                'name' => $categoria["id"] . ' - ' . $categoria['descricao'],



            );
        }

        echo json_encode($data);
    }




    public function telaRerorno()
    {

        return view('Estoque.telaretorno');
    }

    public function entradaLote(Request $request)
    {

        $produtos = $request->input('produto');
        $i = 0;
        $t = count($produtos) - 1;

        $fornecedor = $request->input('fornecedor');
        $nf = $request->input('nf');
        $dt = $request->input('datetimepicker');

        while ($i <= $t) {

            if ($request->input('produto')[$i]) {
                $p = $request->input('produto')[$i];
                $produto = explode(" - ", $p);
                $idProduto = intval($produto[0]);

                //consultar ultimo custo caso não tenha custo
                if ($request->input('custo')[$i] == null) {
                    $custo = Entrada::select('custo')
                        ->where('idConsumiveis', $idProduto)
                        ->orderByDesc('created_at')
                        ->first();
                    $custo = $custo->custo;
                    $custo = str_replace(",", ".", $custo);
                } else {
                    $custo = str_replace(",", ".", $request->input('custo')[$i]);
                }


                $quantidade = $request->input('quantidade')[$i];


                if ($request->input('estadoProduto')[$i] === "Novo") {
                    $novo = 1;
                } else {
                    $novo = 0;
                }

                if ($request->input('tipoEntrada')[$i] === "Compra") {
                    $tipo = 1;
                } else if ($request->input('tipoEntrada')[$i] === "Devolução") {
                    $tipo = 2;
                } else {
                    $tipo = 3;
                }



                $entrada = new Entrada();
                $entrada->idConsumiveis = $idProduto;
                $entrada->fornecedor = $fornecedor;
                $entrada->nf = $nf;
                $entrada->custo = $custo;
                $entrada->quantidade = $quantidade;
                $entrada->novo = $novo;
                $entrada->tipoEntrada = $tipo;
                $entrada->data = $dt;
                $entrada->save();

                /*     $client = new Client();
                $response = $client->get("https://apiessencial.com.br/auvoapp/syncstock/" . $idProduto . "/"); */
            }
            $i++;
        }


        return redirect()->route('homeestoque')->with('success', 'Atualizado.');
    }

    public function prodJson($id)
    {
        $produto = Produto::select()->where('id', $id)->first();
        $catId = ProductsCategorie::select()->where('id', $produto->idTipo)->first();
        if ($produto->idAuvo === null) {
            $produto->idAuvo = 0;
        }

        $ultimoCustoEntrada = Entrada::select('custo')
            ->where('idConsumiveis', $produto->id)
            ->orderBy('id', 'desc')
            ->first();

        $entradas = Entrada::select()
            ->where('idConsumiveis', $produto->id)
            ->sum('quantidade');

        $saidas = Saida::select()
            ->where('idConsumiveis', $produto->id)
            ->sum('quantidade');

        if ($ultimoCustoEntrada === null) {
            $ultimoCustoEntrada = 0;
        } else {
            $ultimoCustoEntrada = $ultimoCustoEntrada->custo;
        }

        if ($entradas === null) {
            $entradas = 0;
        } else {
            $entradas = $entradas;
        }

        if ($saidas === null) {
            $saidas = 0;
        } else {
            $saidas = $saidas;
        }

        $totalEstoque = $entradas - $saidas;
        //$produto->ultimoCustoEntrada = $ultimoCustoEntrada->custo;
        $produto->totalEstoque = $totalEstoque;
        $produto->categoryId = $catId->idAuvo;

        echo json_encode($produto);
    }

    public function syncStok()
    {

        $produtos = Produto::select('id')->get();

        foreach ($produtos as $produto) {
            $client = new Client();
            //$response = $client->get("https://apiessencial.com.br/auvoapp/syncstock/" . $produto->id . "/");
        }
    }

    public function telaSaidaLote()
    {

        return view('Estoque.saidalote');
    }

    public function saidaLote(Request $request)
    {

        $produtos = $request->input('produto');
        $i = 0;
        $t = count($produtos) - 1;

        $solicitante = $request->input('solicitante');
        $cliente = $request->input('cliente');
        $idCliente = explode(" - ", $cliente);
        $idCliente = $idCliente[0];
        $dt = $request->input('datetimepicker');

        while ($i <= $t) {

            if ($request->input('produto')[$i]) {
                $p = $request->input('produto')[$i];
                $produto = explode(" - ", $p);
                $idProduto = intval($produto[0]);


                $quantidade = $request->input('quantidade')[$i];


                if ($request->input('estadoProduto')[$i] === "Novo") {
                    $novo = 1;
                } else {
                    $novo = 0;
                }

                $uc = Entrada::select()
                    ->where('idConsumiveis', $idProduto)
                    ->orderBy('id', 'desc')
                    ->first();

                $ultimoCusto = $uc->custo;



                $saida = new Saida();
                $saida->idConsumiveis = $idProduto;
                $saida->custo = $ultimoCusto;
                $saida->quantidade = $quantidade;
                $saida->estado = $novo;
                $saida->data = $dt;
                $saida->cliente = $cliente;
                $saida->idCliente = $idCliente;
                $saida->solicitante = $solicitante;
                $saida->save();

                $client = new Client();
                //$response = $client->get("https://apiessencial.com.br/auvoapp/syncstock/" . $idProduto . "/");
            }
            $i++;
        }


        return redirect()->route('homeestoque')->with('success', 'Atualizado.');
    }

    public function listCategorie($id)
    {

        $cat = ProductsCategorie::select()->where('id', $id)->first();

        //exibe em formato json
        echo json_encode($cat);
    }

    public function sendRd()
    {

        $ids = produto::select('id')->get();

        foreach ($ids as $id) {
            $client = new Client();
            //$response = $client->get("https://apiessencial.com.br/rd/sendsingleproduct/" . $id->id . "/");
        }
    }

    public function exportaMovimentacoes($dataInicio, $dataFim)
    {
        return Excel::download(new MovimentacoesExport($dataInicio, $dataFim), 'movimentacoes.xlsx');
    }

    /*    public function setClientId()
    {

        $saidas = saida::select()->where('idCliente', null)->get();

        foreach ($saidas as $saida) {
            $nomeCliente = $saida->cliente;
            $idCliente =  client::select('id')->where('nome', $nomeCliente)->first();
            if($idCliente){
                $saida->idCliente = $idCliente->id;
                $saida->save();
            }
        }

    }  */

    public function novoCliente()
    {

        return view('Estoque.novocliente');
    }

    /*     public function setNewClient(Request $req){

        $razaoSocial = $req->input('razaoSocial');
        $nome = $req->input('nome');
        $cnpj = $req->input('cnpj');
        $classificacao = $req->input('classificacao');
        $telefone = $req->input('telefone');
        $cep = $req->input('cep');
        $endereco = $req->input('endereco');
        $bairro = $req->input('bairro');
        $cidade = $req->input('cidade');
        $uf = $req->input('uf');
        $email = $req->input('email');
        $emailCobranca = $req->input('emailCobranca');


        $client = new client();
        $client->razaoSocial = $razaoSocial;
        $client->nome = $nome;
        $client->cnpj = $cnpj;
        $client->classificacao = $classificacao;
        $client->telefone = $telefone;
        $client->cep = $cep;
        $client->endereco = $endereco;
        $client->bairro = $bairro;
        $client->cidade = $cidade;
        $client->uf = $uf;
        $client->email = $email;
        $client->emailCobranca = $emailCobranca;
        $client->save();

        $idCriado = client::select('id')->orderByDesc('id')->first();


        return redirect()->route('detalhecliente', $idCriado->id)->with('success', 'Criado.');

    } */
    public function saidaData()
    {
        // Obtém a data atual
        $dataAtual = now()->format('Y-m-d');

        // Subtrai 7 dias da data atual
        $dataUmaSemanaAtras = now()->subDays(7)->format('Y-m-d');

        // Recupera as saídas no intervalo de datas
        $saidas = Saida::select('saidas.*', 'produtos.*')
            ->join('produtos', 'produtos.id', '=', 'saidas.idConsumiveis')
            ->whereBetween('saidas.created_at', [$dataUmaSemanaAtras, $dataAtual])
            ->get();

        $allAnswers = [];



        // Ou, se preferir, pode percorrer a coleção e imprimir cada resultado individualmente
        foreach ($saidas as $saida) {
            $allAnswers[] = $saida->toArray();
        }

        // Converte o array de respostas para JSON
        $jsonAnswers = json_encode($allAnswers);

        // Imprime o JSON na tela
        echo $jsonAnswers;
    }
}
