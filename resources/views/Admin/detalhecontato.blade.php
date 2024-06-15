@extends('adminlte::page')

@section('title', $dados->nomeEmpresa.' Detalhes')

@section('content_header')
<br>
@endsection

@section('content')

<div class="card p-3 mb-3">



<div class="row">
    <div class="col-md">
        <strong> Nome: </strong> {{$dados->nomeEmpresa}}<br>
        <strong> CNPJ: </strong> {{$dados->cnpj}}<br>
        <strong> Tipo: </strong> {{$dados->razaoContato}}<br>

    </div>


    <div class="col-md">
        <strong> Contato: </strong> {{$dados->nomeContato}}<br>
        <strong> E-mail: </strong> {{$dados->email}}<br>
        <strong> Telefone: </strong> {{$dados->telefone}}<br>
    </div>
</div>

<hr>


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


    <strong>{{\Carbon\Carbon::parse($dados->createdAt)->format('d/m/Y H:i:s')}} </strong> - Inserido novo Contato <br>
    </div>


    <div class="col-md">
    <form method="POST" enctype="multipart/form-data">
    @csrf
    <x-adminlte-textarea name="obs" placeholder="Adicione uma Obervação"/>
    <div class="row justify-content-center">
    <div id="buttons">
    <button class="btn btn-block btn-success" type="submit"><i class="fas fa-upload"></i> Salvar </button>
    </div>
    </div>
    </div>
    </form>

    </div>


</div>
<hr>




@endsection
