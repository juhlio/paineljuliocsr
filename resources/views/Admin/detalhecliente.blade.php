@extends('adminlte::page')

@section('title', $cliente->nome.' Detalhes')

@section('content_header')
<h1>Detalhes de {{$cliente->nome}}</h1>
@endsection

@section('content')

<div class="card p-3 mb-3">

<div class="row">
    <div class="col-md">
        <strong> Razao Social: </strong> {{$cliente->razaoSocial}}<br>
        <strong> Nome Fantasia/Apelido: </strong> {{$cliente->nome}}<br>
        <strong> CNPJ: </strong> {{$cliente->CNPJ}}<br>
    </div>


    <div class="col-md">
        <strong> Endereço: </strong> {{$cliente->endereco}}<br>
        <strong> Bairro: </strong> {{$cliente->bairro}}<br>
        <strong> Estado: </strong> {{$cliente->uf}}<br>
        <strong> CEP: </strong> {{$cliente->cep}} <br>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md">
        <strong> E-mail: </strong> {{$cliente->email}}<br>
        <strong> E-mail Cobrança: </strong> {{$cliente->emailCobranca}}<br>
        <strong> Telefone: </strong> {{$cliente->telefone}}<br>
    </div>


    <div class="col-md">
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md">
        <strong> Vendedor Responsável: </strong> {{$cliente->vendedor}}<br>
        <strong> Técnico Responsável: </strong> {{$cliente->tecnico}}<br>
    </div>


    <div class="col-md">
    </div>
</div>


<br><br>
<div id="buttons">
    <a class="btn btn-success" href="{{route('alteracliente', $cliente->id)}}"><i class="fas fa-upload"></i> Alterar Informações </a>
</div>

<br><br>

<h4>Equipamentos</h4>

<table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fabricante Motor</th>
                <th>Modelo Motor</th>
                <th>Série Motor</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach($maquinas as $maquina)
                <td>{{$maquina->id}}</td>
                <td>{{$maquina->fabricanteMotor}}</td>
                <td>{{$maquina->modeloMotor}}</td>
                <td>{{$maquina->serieMotor}}</td>
                <td> <a class="btn btn-success" href="{{route('detalhemaquina', $maquina->id)}}">Mais Informações</a> </td>
                @endforeach
            </tr>
        
        </tbody>
    </table>

</div>


@endsection