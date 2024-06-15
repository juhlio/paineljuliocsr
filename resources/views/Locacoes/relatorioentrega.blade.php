@extends('adminlte::page')

@section('title', 'Inicio Atendimento Locação Avulsa')

@section('content_header')
<h1> Atendimento Entrega </h1>
@endsection



@section('content')

<form method="POST" enctype="multipart/form-data">
    @csrf


<div class="card p-3 mb-3">

<div class="row">

    <div class="col-md">
    <x-adminlte-input name="idMaquina" label="Id Maquina" value="{{$id}}" readonly
        fgroup-class="col-sm-12" />
    </div>


    <div class="col-md">
    <x-adminlte-input name="atendimento" label="Atendimento" value="Entrega" readonly
        fgroup-class="col-sm-12" />
    </div>
    
    
</div>

<div class="row">

    <div class="col-md">
    <x-adminlte-input name="motor" label="Fabricante Motor" value="{{$dadosEquip->fabricanteMotor}}" readonly
        fgroup-class="col-sm-12" />
    </div>

    <div class="col-md">
    <x-adminlte-input name="modeloMotor" label="Modelo Motor" value="{{$dadosEquip->modeloMotor}}" readonly
        fgroup-class="col-sm-12" />
    </div>

    <div class="col-md">
    <x-adminlte-input name="serieMotor" label="Serie Motor" value="{{$dadosEquip->serieMotor}}" readonly
        fgroup-class="col-sm-12" />
    </div>

    
</div>

<div class="row">

    <div class="col-md">
    <x-adminlte-input name="alternador" label="Fabricante Alternador" value="{{$dadosEquip->fabricanteAlternador}}" readonly
        fgroup-class="col-sm-12" />
    </div>

    <div class="col-md">
    <x-adminlte-input name="modeloAlternador" label="Modelo Alternador" value="{{$dadosEquip->modeloAlternador}}" readonly
        fgroup-class="col-sm-12" />
    </div>

    <div class="col-md">
    <x-adminlte-input name="serieAlternador" label="Serie Alternador" value="{{$dadosEquip->serieAlternador}}" readonly
        fgroup-class="col-sm-12" />
    </div>

    
</div>

<div class="row">

<h5><strong> Dados da Entrega </strong></h5>

</div>



<div class="row">


    <div class="col-md">
    <x-adminlte-input name="cliente" label="Cliente" 
        fgroup-class="col-sm-12" />
    </div>

    <div class="col-md-4">
    <x-adminlte-input name="data" label="Data"  value="{{date('d-m-Y h:i')}}"
        fgroup-class="col-sm-12" />
    </div>

    
</div>




<div class="row">

    <div class="col-md">
    <x-adminlte-input name="endereco" label="Endereço"
        fgroup-class="col-sm-12" />
    </div>



</div>

<div class="row">

    <div class="col-md">
    <x-adminlte-input name="nf" label="Número NF"
        fgroup-class="col-sm-12" />
    </div>

    <div class="col-md">
    <x-adminlte-input name="responsavelEntrega" label="Responsavel pela Entrega"
        fgroup-class="col-sm-12" />
    </div>


    <div class="col-md">
    <x-adminlte-input name="recebidoPor" label="Recebido por"
        fgroup-class="col-sm-12" />
    </div>



</div>



<div class="row">


    <div class="col-md">

        <x-adminlte-select name="abastecimento" label="Abastecimento" 
                igroup-size="md">
                <x-adminlte-options :options="['Cheio' => 'Cheio','3/4' => '3/4', '1/2' => '1/2', '1/4' => '1/4', 'Vazio' => 'Vazio']"
                    empty-option="Escolha uma opção"/>
        </x-adminlte-select>

    </div>

    <div class="col-md">

        <x-adminlte-select name="caminhao" label="Selecione o Caminhão" 
                igroup-size="md">
                <x-adminlte-options :options="['1' => '1','2' => '2', '3' => '3', '4' => '4', '5' => '5']"
                    empty-option="Escolha uma opção"/>
        </x-adminlte-select>

    </div>

    <div class="col-md">
    <x-adminlte-input name="tamanhoEquipe" label="Equipe (Quantidade de Pessoas)"
        fgroup-class="col-sm-12" />
    </div>



</div>


<br><br>
<div id="buttons">
    <button class="btn btn-block btn-success" type="submit"><i class="fas fa-upload"></i> Salvar </button>
</div>

</form>

</div>


@endsection



