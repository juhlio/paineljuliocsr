@extends('adminlte::page')

@section('title', 'Lista de Maquinas')



@section('content')

<br>
<div class="card p-4">


    <div class="row">

        <div class="col-md-3 mb-3">
        <a href="{{ route('novaMaquinaLocacao') }}" class="btn btn-success btn-block"> + Máquina</a>
        </div>

    </div>

    <table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fabricante</th>
                <th>Potencia</th>
                <th>Série</th>
                <th>Detalhes</th>
                <th>Alterar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($maquinas as $maquina)
            <tr>
                <td>{{$maquina->id}}</td>
                <td>{{$maquina->fabricanteEquipamento}}</td>
                <td>{{$maquina->potencia}}</td>
                <td>{{$maquina->serieEquipamento}}</td>
                <td> <a class="btn btn-success" href="{{route('detalheMaquinaLocacao', $maquina->id)}}">Mais Informações</a> </td>
                <td> <a class="btn btn-success" href="#">Alterar</a> </td>
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
