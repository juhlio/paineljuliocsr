<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requisicaocompra;
use App\Models\Produtosrequisicaocompra;
use App\Models\Produto;
use App\Models\Client;
use App\Models\User;
use App\Models\Obsreqcompra;
use Carbon\Carbon;
use PhpParser\Node\Stmt\TryCatch;
use App\Mail\ConfirmaRequisicao;
use App\Mail\NovaRequisicaoCompra;
use App\Mail\RequisicaoRejeitada;
use App\Mail\MailObsReqCompra;
use Illuminate\Support\Facades\Mail;

class ComprasController extends Controller
{
    public function index()
    {

        //busca todas as requisições de compra com join em clients
        $pedidos = Requisicaocompra::select('clients.nome', 'requisicaocompras.*', 'users.name')
            ->join('clients', 'requisicaocompras.idCliente', '=', 'clients.id')
            ->join('users', 'requisicaocompras.solicitante', '=', 'users.id')
            ->orderBy('requisicaocompras.id', 'desc')
            ->get();

        //total de requisições de compra
        $total = Requisicaocompra::count();

        foreach ($pedidos as $pedido) {
            if ($pedido->tipo == 1) {
                $pedido->tipo = 'Orçamento';
            } else if ($pedido->tipo == 2) {
                $pedido->tipo = 'Compra';
            } else {
                $pedido->tipo = 'Separação';
            }

            if ($pedido->resp) {
                $resp = User::select('name')->where('id', $pedido->resp)->first();
                $pedido->resp = $resp->name;
            } else {
                $pedido->resp = 'Não Atribuido';
            }

            if ($pedido->status == 1) {
                $pedido->status = 'Aberto';
            } else if ($pedido->status == 2) {
                $pedido->status = 'Em analise';
            } else if ($pedido->status == 3) {
                $pedido->status = 'Em separação';
            } else if ($pedido->status == 4) {
                $pedido->status = 'Separado';
            } else if ($pedido->status == 5) {
                $pedido->status = 'Em conferencia';
            } else if ($pedido->status == 6) {
                $pedido->status = 'Conferido';
            } else if ($pedido->status == 99) {
                $pedido->status = 'Rejeitado';
            }
        };

        return view('Compras.index', [
            'pedidos' => $pedidos,
            'total' => $total
        ]);
    }

    public function telaRequisicoes()
    {
        return view('Compras.telarequisicoes');
    }

    public function processaRequisicao(Request $req)
    {
        //pega o id do user para colocar na solicitação
        $solicitante = auth()->user()->id;

        $c = $req->input('cliente');
        $cliente = explode(" - ", $c);
        $idCliente = $cliente[0];
        $produtos = $req->input('produto');

        if ($req->input('tipo') === 'Orçamento') {
            $tipo = 1;
        } else if ($req->input('tipo') === 'Compra') {
            $tipo = 2;
        } else {
            $tipo = 3;
        }

        $data = Carbon::createFromFormat('d/m/Y', $req->input('datetimepicker'));
        $bdData = $data->format('Y-m-d');


        $requisicao = new Requisicaocompra();
        $requisicao->idCliente = $idCliente;
        $requisicao->tipo = $tipo;
        $requisicao->data = $bdData;
        $requisicao->solicitante = $solicitante;
        $requisicao->status = 1;
        $requisicao->save();

        $idRequisicao = Requisicaocompra::select('id')->orderBy('id', 'desc')->first();

        $t = count($produtos) - 1;
        $i = 0;


        while ($i < $t) {
            $produto = explode(" - ", $produtos[$i]);
            $idProduto = $produto[0];
            $quantidade = $req->input('quantidade')[$i];

            try {
                $verProd = Produto::select('descricao')->where('descricao', $produto[1])->first();
                $descricao = $produto[1];
            } catch (\Throwable $th) {
                $verProd = null;
                $descricao = $produtos[$i];
            }

            if ($verProd == null) {
                $cadastrado = 0;
                $idProduto = 0;
            } else {
                $cadastrado = 1;
            }

            $produtosRequisicao = new Produtosrequisicaocompra();
            $produtosRequisicao->idRequisicao = $idRequisicao->id;
            $produtosRequisicao->produtoCadastrado = $cadastrado;
            $produtosRequisicao->produto = $idProduto;
            $produtosRequisicao->descricao = $descricao;


            $produtosRequisicao->obs = $req->input('obs')[$i];
            $produtosRequisicao->quantidade = $quantidade;
            $produtosRequisicao->tipo = 1;
            $produtosRequisicao->save();


            $i++;
        }

        $nomeSolicitante = User::select('name')->where('id', $solicitante)->first();
        $nomeCliente = Client::select('nome')->where('id', $idCliente)->first();
        $nomeTipo = $req->input('tipo');
        $produtos = Produtosrequisicaocompra::select('descricao', 'quantidade')->where('idRequisicao', $idRequisicao->id)->get();
        $mailSolicitante = User::select('email')->where('id', $solicitante)->first();

        Mail::to($mailSolicitante->email)->send(new ConfirmaRequisicao($nomeSolicitante, $nomeCliente, $nomeTipo, $produtos, $idRequisicao->id));

        Mail::to('julioramos.esporte@gmail.com')->send(new NovaRequisicaoCompra($nomeSolicitante, $nomeCliente, $nomeTipo, $produtos, $idRequisicao->id));

        return redirect()->route('telaRequisicoes')->with('success', 'Requisição criada com sucesso!');
    }

    public function detalheRequisicao($id)
    {

        $detail = Requisicaocompra::select('requisicaocompras.*', 'clients.nome')
            ->join('clients', 'requisicaocompras.idCliente', '=', 'clients.id')
            ->where('requisicaocompras.id', $id)->first();

        if ($detail->resp) {
            $resp = User::select('name')->where('id', $detail->resp)->first();
            $detail->resp = $resp->name;
        } else {
            $detail->resp = 'Não Atribuido';
        }

        if ($detail->tipo == 1) {
            $detail->tipo = 'Orçamento';
        } else if ($detail->tipo == 2) {
            $detail->tipo = 'Compra';
        } else {
            $detail->tipo = 'Separação';
        }

        if ($detail->status == 1) {
            $detail->status = 'Aberto';
        } else if ($detail->status == 2) {
            $detail->status = 'Em analise';
        } else if ($detail->status == 3) {
            $detail->status = 'Em separação';
        } else if ($detail->status == 4) {
            $detail->status = 'Separado';
        } else if ($detail->status == 5) {
            $detail->status = 'Em conferencia';
        } else if ($detail->status == 6) {
            $detail->status = 'Conferido';
        } else if ($detail->status == 99) {
            $detail->status = 'Rejeitado';
        }





        $products = Produtosrequisicaocompra::select()->where('idRequisicao', $id)->get();

        foreach ($products as $product) {
            if ($product->produtoCadastrado == 1) {
                $product->produtoCadastrado = 'Sim';
                $product->descricaoProduto = Produto::select('descricao')->where('id', $product->produto)->first();
            } else {
                $product->produtoCadastrado = 'Não';
            }
        }

        //buscar observações de forma descendente
        $observacoes = Obsreqcompra::select()
            ->where('idreqcompra', $id)
            ->orderBy('created_at', 'desc')
            ->get();


        return view('Compras.detalheRequisicao', [
            'detail' => $detail,
            'products' => $products,
            'id' => $id,
            'observacoes' => $observacoes
        ]);
    }

    public function insereObsReqCompra(request $request, $reqcompra)
    {
        $obs = filter_input(INPUT_POST, 'obs');

        Obsreqcompra::create([
            'idreqcompra' => $reqcompra,
            'obs' => $obs
        ]);

        if ($request->has('enviar_email')) {
            $solicitante = Requisicaocompra::select('solicitante')->where('id', $reqcompra)->first();
            $dadosSolicitante = User::select()->where('id', $solicitante->solicitante)->first();


            Mail::to($dadosSolicitante->email)->send(new MailObsReqCompra($reqcompra, $obs, $dadosSolicitante));
        }

        return redirect()->route('detalheRequisicao', $reqcompra)->with('success', 'Observação inserida com sucesso!');
    }

    public function rejeitaRequisicao($id)
    {

        $requisicao = Requisicaocompra::select()->where('id', $id)->first();
        $requisicao->status = 99;
        $requisicao->save();




        $obs = filter_input(INPUT_POST, 'obs');

        Obsreqcompra::create([
            'idreqcompra' => $id,
            'obs' => 'Requisição rejeitada'
        ]);

        Obsreqcompra::create([
            'idreqcompra' => $id,
            'obs' => $obs
        ]);

        $cliente = Client::select()->where('id', $requisicao->idCliente)->first();
        $solicitante = User::select('name', 'email')->where('id', $requisicao->solicitante)->first();
        $produtos = Produtosrequisicaocompra::select()->where('idRequisicao', $id)->get();

        Mail::to($solicitante->email)->send(new RequisicaoRejeitada($obs, $id, $requisicao, $cliente, $produtos, $solicitante));

        return redirect()->route('detalheRequisicao', $id)->with('success', 'Requisição rejeitada com sucesso!');
    }

    public function selecionaResponsavel($id)
    {

        $responsavel = filter_input(INPUT_POST, 'responsavel');

        if ($responsavel == 'Gustavo') {
            $idResponsavel = 7;
        } else if ($responsavel == 'Luiz') {
            $idResponsavel = 4;
        } else if ($responsavel == 'Yuri') {
            $idResponsavel = 8;
        }


        $requisicao = Requisicaocompra::select()->where('id', $id)->first();
        $requisicao->resp = $idResponsavel;
        $requisicao->save();

        Obsreqcompra::create([
            'idreqcompra' => $id,
            'obs' => 'Responsável adicionado: ' . $responsavel
        ]);


        return redirect()->route('detalheRequisicao', $id)->with('success', 'Responsável selecionado com sucesso!');
    }

    public function upProdReqCompra(Request $request, $id)
    {
        $produto = Produtosrequisicaocompra::select()->where('id', $id)->first();
        $produto->custo = $request->input('custo');
        $produto->obs = $request->input('obs');
        $produto->save();


        return response()->json(['message' => 'Produto atualizado com sucesso.']);
    }

    public function atualizaValor(request $req)
    {

        $id = $req->input('id');
        $custo = $req->input('custo');
        $obs = $req->input('obs');

        //converter o valor para float
        $custo = str_replace(',', '.', $custo);

        $produto = Produtosrequisicaocompra::select()->where('id', $id)->first();
        if (!empty($custo)) {
            $produto->precoOrcamento = $custo;
        }

        if (!empty($obs)) {
            $produto->obs = $obs;
        }
        $produto->save();

        return response()->json(['message' => 'Valor atualizado com sucesso.']);
    }
}
