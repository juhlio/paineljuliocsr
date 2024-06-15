@extends('adminlte::page')

@section('title', 'Imagens Equipamento')

@section('content_header')
<h4>Imagens Equipamento</h4>
@endsection

@section('content')

<form action="{{ route('processaEnvioImagens', $id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div>
        <h5>Envie aqui as imagens</h5>
        <input name="fotos[]" type="file" multiple />
    </div>
    <br>
    <button type="submit" class="btn btn-block btn-success"><i class="fas fa-upload"></i> Enviar </button>
</form>

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

<script>
    // Remova a configuração do Dropzone
</script>
@endsection
