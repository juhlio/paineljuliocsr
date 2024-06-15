@extends('adminlte::page')

@section('title', 'Novo Chamado')

@section('content_header')
<h1> Novo Chamado </h1>
@endsection



@section('content')

<form method="POST" enctype="multipart/form-data">
    @csrf


<div class="card p-3 mb-3">

<div class="row">

    <div class="col-md">
    <x-adminlte-input name="os" label="O.S."
        fgroup-class="col-sm-12" />
    </div>

    <div class="col-md">
    <x-adminlte-input name="cliente" label="Cliente"
        fgroup-class="col-sm-12" />
    </div>

    <div class="col-md">
    <x-adminlte-input name="data" label="Data do Chamado"  value="{{date('d-m-Y')}}"
        fgroup-class="col-sm-12" />
    </div>

    <div class="col-md">
    <x-adminlte-input name="atendimento" label="Atendimento" value="Atendimento" disabled
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
        <x-adminlte-select name="tipoAtendimento" label="Tipo" id="tipo"
            igroup-size="md">
            <x-adminlte-options :options="['Emergencial' => 'Emergencial','Programado' => 'Programado']"
                disabled="1" empty-option="Escolha uma opção"/>
        </x-adminlte-select>

    </div>

    <div class="col-md">
    <x-adminlte-input name="potencia" label="Potência"
        fgroup-class="col-sm-12" />
    </div>


</div>

<div class="row" id="data-atendimento-row">

    <div class="col-md">
    <x-adminlte-input name="dataAtendimento" label="Data do atendimento" value="{{date('d-m-Y H:i')}}"
        fgroup-class="col-sm-12" />
    </div>

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

@section('css')

<link rel="stylesheet" type="text/css" href="{{ url('vendor/dropify/dropify.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">


@endsection

@section('js')

<script>

// Obtém os elementos HTML dos campos de "Status" e "Horímetro"

const tipoInput = document.getElementById('tipo');
const dataAtendimentoRow = document.getElementById('data-atendimento-row')


// Função que será chamada toda vez que o valor do campo "Status" for alterado
function atualizaDataAtendimentoRow() {

  if (tipoInput.value === 'Programado') {
    dataAtendimentoRow.style.display = 'table-row';
  } else {
    dataAtendimentoRow.style.display = 'none';
  }
}

// Registra a função "atualizarHorimetroVisibilidade" para ser chamada toda vez que o valor do campo "Status" for alterado
tipoInput.addEventListener('change', atualizaDataAtendimentoRow)

// Chama a função uma vez para definir a visibilidade inicial do campo "Horímetro"
atualizaDataAtendimentoRow();

</script>

<script src="{{ url('vendor/autocomplete/jquery.easy-autocomplete.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"> </script>

  <script> $('.dropify').dropify({
    messages: {
        'default': 'Insira a Imagem',
        'replace': 'Arraste e solte ou clique para trocar a imagem',
        'remove':  'Remover',
        'error':   'Ooops, algo errado aconteceu.'
    }
  }); </script>



@endsection
