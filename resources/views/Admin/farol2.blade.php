@extends('adminlte::page')

<!--  @php

echo '<pre>';
    echo print_r($tasks[0]);
echo '</pre>';
@endphp -->



@section('title', 'Farol')
@section('content')

<br>

<div class="card p-3 mb-3">

    <div class="row">

        <div class="col-md-4">

            <x-adminlte-small-box title="{{$totalVermelho}}" text="Inoperante" theme="danger" />

        </div>

        <div class="col-md-4">
            <x-adminlte-small-box title="{{$totalAmarelo}}" text="Operando com restrição" theme="warning" />
        </div>

        <div class="col-md-4">
            <x-adminlte-small-box title="{{$totalVerde}}" text="Operando Normalmente" theme="success" />
        </div>

    </div>


    <table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>Cód Atendimento</th>
                <th>Status</th>
                <th>Cliente</th>
                <th>Apelido</th>
                <th>Relato</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            @if(mb_strtolower($task->reply, 'UTF-8') == 'operando normalmente')
            <tr class="bg-success">
                @elseif(mb_strtolower($task->reply, 'UTF-8') == 'operando com restrição')
            <tr class="bg-warning">
                @elseif (mb_strtolower($task->reply, 'UTF-8') == 'inoperante')
            <tr class="bg-danger">
                @endif

                <td> <a href="https://app2.auvo.com.br/relatorioTarefas/DetalheTarefa/{{ $task->taskId }}" style="color: inherit; text-decoration: none;" target="_blank"> {{$task->taskId}} </a> </td>
                <td>{{$task->reply}}</td>
                <td>{{$task->razaoSocial}}</td>
                <td>{{$task->nome}}</td>
                <td>{{$task->obs}}</td>


            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection


@section('css')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">


@endsection

@section('js')

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.js"> </script>



<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "language": {
                "search": "Buscar",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "info": "Página _PAGE_ de _PAGES_",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Próxima",
                    "first": "Primeira",
                    "last": "Última"
                }
            },
            "order": [
                [0, "desc"]
            ],
            responsive: true
        });
    });
</script>

@endsection
