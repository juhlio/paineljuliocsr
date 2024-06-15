@extends('adminlte::page')

@section('content_header')
<h1>Detalhes Atendimento </h1>
@endsection

@section('content')

<div class="card p-3 mb-3">

<div class="row justify-content-center">
    <h4>Atendimento Número: {{$id}} </h4>
</div>

<div class="row">

    <div class="col-md">
        <strong> Endereço:</strong> {{$atendimento->endereco}} <br>
        <strong> Tipo Atendimento: </strong> {{$atendimento->tipoAtendimento}} <br>
        <strong> Hora Chamado: </strong> {{\Carbon\Carbon::parse($atendimento->horaChamado)->format('d/m/Y h:i')}}  <br>
        <strong> Tipo Conexão: </strong>  {{$atendimento->tipoConexao}}<br>
        <strong> Chegada GMG: </strong> {{\Carbon\Carbon::parse($atendimento->chegadaGmg)->format('d/m/Y h:i')}}  <br>
        <strong> Caminhão: </strong> {{$atendimento->caminhao}} <br>
    </div>
    <div class="col-md">
      
    </div>

</div>

<hr>

<div class="row">
    <div class="col-md">
        
        <strong>CABEAMENTO TRANSPORTADO</strong><br><br>
        <strong> Secção do Condutor: </strong> {{$atendimento->seccaoCondutorTransportado}} <br>
        <strong> Lances por Fase: </strong> {{$atendimento->lancesPorFaseTransportado}}  <br>
        <strong> Lances Neutro: </strong>  {{$atendimento->lancesNeutroTransportado}}<br>
    </div>

    @if ($atendimento->seccaoCondutorUtilizado)
    <div class="col-md">
        
        <strong>CABEAMENTO Utilizado</strong><br><br>
        <strong> Secção do Condutor: </strong> {{$atendimento->seccaoCondutorUtilizado}} <br>
        <strong> Lances por Fase: </strong> {{$atendimento->lancesPorFaseUtilizado}}  <br>
        <strong> Lances Neutro: </strong>  {{$atendimento->lancesNeutroUtilizado}}<br>
    </div>
    @endif
<hr>

</div>

<hr>


@if($atendimento->horimetroInicial)
<div class="row">

    <div class="col-md">
        <strong> Inicio Operação:</strong> {{\Carbon\Carbon::parse($atendimento->inicioOperacao)->format('d/m/Y h:i')}} <br>
        <strong> Horimetro Inicial: </strong> {{$atendimento->horimetroInicial}} <br>
        <strong> KWH Inicial </strong> {{$atendimento->kwhInicial}} <br>
    </div>

    @if($atendimento->terminoOperacao)
    <div class="col-md">
        <strong> Termino Operação:</strong> {{\Carbon\Carbon::parse($atendimento->terminoOperacao)->format('d/m/Y h:i')}} <br>
        <strong> Horimetro Final: </strong> {{$atendimento->horimetroFinal}} <br>
        <strong> KWH Final: </strong> {{$atendimento->kwhFinal}} <br>
    </div>
    @endif

</div>
<hr>
@endif

<div class="row">
    
    <div class="col-md">
        
        <strong>Atualizações</strong><br>
        @foreach ($atualizacoes as $atualizacao)
        {{$atualizacao->obs}} | {{\Carbon\Carbon::parse($atualizacao->created_at)->format('d/m/Y h:i')}} <br>
        @endforeach
    </div>
  


</div>


</div>

@endsection


@section('css')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">


@endsection

@section('js')

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script>



@endsection