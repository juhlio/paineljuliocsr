@extends('adminlte::page')

@section('title', 'Lista de Chamados')



@section('content')

<br>
<div class="card p-4">

    <table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>solicitante</th>
                <th>Cargo</th>
                <th>Telefone</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calls as $call)
            <tr>
                <td>{{$call->id}}</td>
                <td>{{$call->name}}</td>
                <td>{{$call->contactName}}</td>
                <td>{{$call->position}}</td>
                <td>{{$call->phone}}</td>
                <td>{{$call->description}}</td>
                <td> <a class="btn btn-success" href="{{route('detalheChamado', $call->id)}}">Mais Informações</a> </td>
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
                },
                "columnDefs": [{
                    "orderable": true,
                    "targets": 0
                }],
                "order": [
                    [0, "desc"]
                ],
            },
            responsive: true
        });
    });
</script>


@endsection