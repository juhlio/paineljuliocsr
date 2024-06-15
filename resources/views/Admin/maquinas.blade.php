@extends('adminlte::page')

@section('title', 'Lista de Maquinas')



@section('content')
<br>

<div class="card p-4">

<table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Identificação</th>
                <th>Detalhes</th>
                <th>Alterar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($maquinas as $maquina)
            <tr>
                <td>{{$maquina->id}}</td>
                <td>{{$maquina->nome}}</td>
                <td>{{$maquina->auvoId}}</td>
                <td> <a class="btn btn-success" href="{{route('detalhemaquina', $maquina->id)}}">Mais Informações</a> </td>
                <td> <a class="btn btn-success" href="{{route('alteramaquina', $maquina->id)}}">Alterar</a> </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection


@section('css')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.css">


@endsection

@section('js')

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.js"> </script>

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
            },
            "columnDefs": [
            { "orderable": true, "targets": 0 }
        ],
        "order": [[0, "desc"]],
        }, responsive: true
    });
});

</script>

@endsection
