@extends('adminlte::page')


@section('content')

    <br>

<div class="card p-3 mb-3">

<div class="row">

    <div class="col-md-4">

        <x-adminlte-small-box title="Tela Principal" text="Retorna a tela principal do estoque"
        theme="primary"  url="{{route('homeestoque')}}"  />

    </div>

    <div class="col-md-4">
        <x-adminlte-small-box title="Movimentações" text="Com filtro por data"
        theme="primary" url="{{route('telamovimentacoes')}}"  />
    </div>



</div>

<table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>Data</th>
                <th>Fechamento do Dia</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fechamentos as $fechamento)
            <tr>
                <td>{{$fechamento->created_at->format('d/m/Y')}}</td>
                <td>R$ {{number_format($fechamento->valor, 2, ',', '.')}}</td>
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
