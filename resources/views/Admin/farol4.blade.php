@extends('adminlte::page')
@section('title', 'Farol')
@section('content')

<br>

<div class="card p-3 mb-3">

    <div class="row">

        <div class="col-md-12 mt-3 mb-3">
            <a href="{{ route('exportaFarol') }}" class="btn btn-primary">Baixar Planilha</a>
        </div>

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

                <th>Atendimento</th>
                <th>Tipo</th>
                <th>Data</th>
                <th>Status</th>
                <th>Cliente</th>
                <th>Apelido</th>
                <th>Relato</th>


            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)

            @if(mb_strtolower($task->status, 'UTF-8') == 'operando normalmente')
            <tr class="bg-success">
                @elseif(mb_strtolower($task->status, 'UTF-8') == 'operando com restrição')
            <tr class="bg-warning">
                @elseif (mb_strtolower($task->status, 'UTF-8') == 'inoperante')
            <tr class="bg-danger">
                @endif


                <td> <a href="https://app2.auvo.com.br/relatorioTarefas/DetalheTarefa/{{$task->taskId}}" style="color: inherit; text-decoration: none;" target="_blank"> {{$task->taskId}} </a> </td>
                <td> {{$task->type}}</td>
                <td> {{ \DateTime::createFromFormat('Y-m-d H:i:s', $task->made_at)->format('d/m/Y') }}</td>
                <td> {{ ucfirst($task->status) }}</td>
                <td> {{$task->razaoSocial}}</td>
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
            "columnDefs": [{
                "targets": [0], // Defina a primeira coluna como data
                "type": "date-eu" // Especifique o tipo de data (formato europeu)
            }],
            "order": [
                [0, "desc"] // Defina a ordem inicial pela primeira coluna (data)
            ],
            responsive: true
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Define a função para recarregar a página
        function recarregarPagina() {
            location.reload(); // Recarrega a página
        }

        // Chama a função para recarregar a página a cada 10 minutos (600000 milissegundos)
        setInterval(recarregarPagina, 600000);
    });
</script>


@endsection
