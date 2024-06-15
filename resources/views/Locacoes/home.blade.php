@extends('adminlte::page')


@section('content')

<br>
<div class="card p-3 mb-3">

<div class="row">

    <div class="col-md-4">

        <x-adminlte-small-box title="Chamados" text="Chamados Criados"
        theme="primary"  url="{{route('telachamados')}}"  />

    </div>

    <div class="col-md-4">
        <x-adminlte-small-box title="Novo Chamado" text="Cria novo Chamado"
        theme="primary" url="{{route('maquinasEnel')}}"  />
    </div>


</div>

<div class="row">

    <div class="col-md-4">

        <x-adminlte-small-box title="Lista dos Atendimentos" text="Atendimentos Realizados"
        theme="primary"  url="{{route('listaAtendimentos')}}"  />

    </div>

    <div class="col-md-4">
        <x-adminlte-small-box title="Equipamentos" text="Equipamentos Cadastrados"
        theme="primary" url="{{route('maquinasEnel')}}"  />
    </div>

    <div class="col-md-4">
        <x-adminlte-small-box title="Caminhões" text="Caminhões Cadastrados"
        theme="primary" url="#"  />
    </div>

</div>



@endsection


@section('css')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">


@endsection

@section('js')

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script>


<script>
$(document).ready(function () {
    $('#example').DataTable({
        "language":{
            "search": "Buscar",
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "info": "Página _PAGE_ de _PAGES_",
            "paginate": {
                "previous" : "Anterior",
                "next": "Próxima",
                "first": "Primeira",
                "last": "Última"
            }
        }
    });
});
</script>

@endsection
