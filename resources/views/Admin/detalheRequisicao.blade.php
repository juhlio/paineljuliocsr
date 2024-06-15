
@extends('adminlte::page')

@section('title', 'Requisição')

@section('content_header')
<h4>Requisição N.º {{$id}} </h4>
@endsection

@section('content')

<div class="card p-3 mb-3">
    <div class="row">
        <div class="col-md">
            <strong>Cliente:</strong> {{$detail->nome}} <br>
            <strong>Data:</strong> {{ date('d/m/Y', strtotime($detail->data)) }} <br>
            <strong>Tipo Solicitação:</strong> {{$detail->tipo}} <br>
            <strong>Status:</strong> {{$detail->status}} <br>
            <strong>Responsável:</strong> {{$detail->resp}}
        </div>
    </div>

    <hr>

    <h4>Itens da Requisição</h4>
    @foreach($products as $product)
        <div class="row">
            <div class="col-md-4">
                <strong>Produto/Serviço:</strong> @if ($product->produtoCadastrado === 'Sim') {{$product->descricaoProduto->descricao}}
                @else {{$product->descricao}} @endif
            </div>
            <div class="col-md-2">
                <strong>Quantidade:</strong> {{$product->quantidade}}
            </div>
            <div class="col-md-6">
                <strong>Obs:</strong> {{$product->obs}}
            </div>
        </div>
    @endforeach

    <br>
    <hr>

    <div class="row">
        <div class="col-md">
            <h3>Histórico</h3>
            <br>
            @if($observacoes)
                @foreach($observacoes as $observacao)
                    <strong>{{\Carbon\Carbon::parse($observacao->created_at)->format('d/m/Y H:i:s')}}</strong> - {{$observacao->obs}} <br>
                @endforeach
            @endif
            <strong>{{\Carbon\Carbon::parse($detail->created_at)->format('d/m/Y H:i:s')}} </strong> - Requisição Criada <br>
        </div>


    </div>

    <hr>
    <br>

    <div class="row justify-content-center">
        <a class="btn btn-danger mr-3" href="{{route('telaListaRequisicoes')}}">Voltar</a>
        <!-- Botão para acionar o pop-up (modal) -->
    </div>

</div>



@endsection
