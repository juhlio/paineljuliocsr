@php
use Carbon\Carbon;
$data = Carbon::now();
$chegadaGmgFormatada = $dadosRelatorio->chegadaGmg ? Carbon::parse($dadosRelatorio->chegadaGmg)->format('d/m/Y H:i:s') : '';
@endphp

@extends('adminlte::page')

@section('title', 'Finaliza Locação')

@section('content_header')
<h1> Atendimento </h1>
@endsection

@section('content')

<form method="POST" enctype="multipart/form-data">
    @csrf


    <div class="card p-3 mb-3">

        <div class="row">

            <div class="col-md">
                <x-adminlte-input name="atendimento" label="Atendimento" value="Locação" readonly fgroup-class="col-sm-12" />
            </div>


        </div>




        <div class="row">

            <div class="col-md">
                <x-adminlte-input name="endereco" label="Endereço" value="{{$dadosRelatorio->endereco}}" readonly fgroup-class="col-sm-12" />
            </div>

            <div class="col-md">
                <x-adminlte-input name="tipoAtendimento" label="Tipo" value="{{$dadosRelatorio->tipoAtendimento}}" readonly fgroup-class="col-sm-12" />
            </div>

            <div class="col-md">
                <x-adminlte-input name="chegadaGmg" label="Chegada Do GMG" value="{{$chegadaGmgFormatada}}" readonly fgroup-class="col-sm-12" />
            </div>



        </div>


        <div class="row">

            <div class="col-md">
                <x-adminlte-input name="tipoConexao" label="Conexão" value="{{$dadosRelatorio->tipoConexao}}" readonly fgroup-class="col-sm-12" />
            </div>

            <div class="col-md">
                <x-adminlte-input name="caminhao" label="Caminhao" value="{{$dadosRelatorio->caminhao}}" readonly fgroup-class="col-sm-12" />
            </div>



        </div>


        <div class="row">

            <div class="col-md">
                <x-adminlte-input name="horimetroFinal" label="Horimento Final" fgroup-class="col-sm-12" />
            </div>


            <div class="col-md">
                <x-adminlte-input name="kwhFinal" label="Kwh Final" fgroup-class="col-sm-12" />
            </div>



        </div>


        <div class="row">

            <div class="col-md">

                <x-adminlte-textarea name="obsGerais" label="Observações gerais" />

            </div>

        </div>



        <br><br>
        <div id="buttons">
            <button class="btn btn-block btn-success" type="submit"><i class="fas fa-upload"></i> Salvar </button>
        </div>

</form>

</div>


@endsection