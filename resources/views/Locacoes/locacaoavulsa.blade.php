@extends('adminlte::page')

@section('title', 'Inicio Atendimento Locação Avulsa')

@section('content_header')
<h1> Atendimento Locação Avulsa </h1>
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
    <x-adminlte-input name="atendimento" label="Atendimento" value="Locação Avulsa" readonly
        fgroup-class="col-sm-12" />
    </div>
    
    
</div>

<div class="row">


    <div class="col-md">
    <x-adminlte-input name="cliente" label="Cliente" 
        fgroup-class="col-sm-12" />
    </div>

    <div class="col-md">
    <x-adminlte-input name="data" label="Data"  value="{{date('d-m-Y')}}"
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
        <x-adminlte-select name="tipoConexao" label="Tipo Conexão" 
            igroup-size="md">
            <x-adminlte-options :options="['Subterrânea' => 'Subterrânea','Aérea' => 'Aérea']"
                disabled="1" empty-option="Escolha uma opção"/>
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
        <x-adminlte-input name="chegadaGmg" label="Chegada GMG" value="{{date('d-m-Y d:i')}}"
            fgroup-class="col-sm-12" />
    </div>


</div>


<h4>Cabeamento Transportado</h4>

<div class="row">

    <div class="col-md">
        <x-adminlte-select name="seccaoCondutorTransportado" label="Secção do Condutor" 
        igroup-size="md">
            <x-adminlte-options :options="['70' => '70mm', '95' => '95mm', '120' => '120mm',
            '240' => '240mm']"
            disabled="1" empty-option="Escolha uma opção"/>
        </x-adminlte-select> 
    </div>


    <div class="col-md">
        <x-adminlte-select name="lancesFaseTransportado" label="Lances por Fase" 
        igroup-size="md">
            <x-adminlte-options :options="['1' => '1', '2' => '2', '3' => '3',
            '4' => '4', '5' => '5', '6' => '6']"
            empty-option="Escolha uma opção"/>
        </x-adminlte-select>

    </div>

    <div class="col-md">
        <x-adminlte-select name="lancesNeutroTransportado" label="Lances Neutro" 
        igroup-size="md">
            <x-adminlte-options :options="['1' => '1', '2' => '2', '3' => '3',
            '4' => '4', '5' => '5', '6' => '6']"
            empty-option="Escolha uma opção"/>
        </x-adminlte-select>

    </div>

</div>

<div class="row">

    <hr>

    <div class="col-md">
        <x-adminlte-input name="horimetroInicial" label="Horimento Inicial" 
        fgroup-class="col-sm-12" />
    </div>


    <div class="col-md">
        <x-adminlte-input name="kwhInicial" label="Kwh Inicial" 
        fgroup-class="col-sm-12" />
    </div>


    <div class="col-md">
        <x-adminlte-input name="inicioOperacao" label="Inicio da Operação" value="{{date('d-m-Y d:i')}}"
        fgroup-class="col-sm-12" />
    </div> 

</div>


<h4>Cabeamento Utilizado</h4> 

<div class="row">

    <div class="col-md">
        <x-adminlte-select name="seccaoCondutorUtilizado" label="Secção do Condutor" 
        igroup-size="md">
            <x-adminlte-options :options="['70' => '70mm', '95' => '95mm', '120' => '120mm',
            '240' => '240mm']"
            disabled="1" empty-option="Escolha uma opção"/>
        </x-adminlte-select> 
    </div>


    <div class="col-md">
        <x-adminlte-select name="lancesPorFaseUtilizado" label="Lances por Fase" 
        igroup-size="md">
            <x-adminlte-options :options="['1' => '1', '2' => '2', '3' => '3',
            '4' => '4', '5' => '5', '6' => '6']"
            empty-option="Escolha uma opção"/>
        </x-adminlte-select>

    </div>

    <div class="col-md">
        <x-adminlte-select name="lancesNeutroUtilizado" label="Lances Neutro" 
        igroup-size="md">
            <x-adminlte-options :options="['1' => '1', '2' => '2', '3' => '3',
            '4' => '4', '5' => '5', '6' => '6']"
            empty-option="Escolha uma opção"/>
        </x-adminlte-select>

    </div>

</div>



<div class="row">

    <div class="col-md">

    <x-adminlte-textarea name="obsGerais" label="Observações gerais"/>
    
    </div>

</div>



<br><br>
<div id="buttons">
    <button class="btn btn-block btn-success" type="submit"><i class="fas fa-upload"></i> Salvar </button>
</div>

</form>

</div>


@endsection



