@extends('adminlte::page')

@section('content_header')
<h4>Entrada no Estoque com arquivo xml</h4>
@endsection

@section('content')

<form method="POST" enctype="multipart/form-data">
    @csrf

    <div class="col-sm">
            <h5>Envie aqui o arquivo</h5>
    <input type="file"  name="xml" class="dropify" data-max-file-size="3M" data-show-errors="true"  />
    </div>

<br><br>
<div id="buttons">
    <button class="btn btn-block btn-success" id="concluir" type="submit"><i class="fas fa-upload"></i> Enviar </button>
</div>



</form>


@endsection

@section('css')

<link rel="stylesheet" type="text/css" href="{{ url('vendor/dropify/dropify.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">


@endsection


@section('js')

<script src="{{ url('vendor/autocomplete/jquery.easy-autocomplete.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"> </script>

<script> $('.dropify').dropify({
    messages: {
        'default': 'Insira o arquivo',
        'replace': 'Arraste e solte ou clique para trocar a imagem',
        'remove':  'Remover',
        'error':   'Ooops, algo errado aconteceu.'
    }
}); </script>

@endsection
