@extends('adminlte::page')


@section('content')

    <br>

<div class="card p-3 mb-3">

<div class="row">

    {{-- <div class="col-md-4">

        <x-adminlte-small-box title="Movimentações" text="Com filtro por data"
        theme="primary"  url="{{route('telamovimentacoes')}}"  />

    </div> --}}

    {{--  <div class="col-md-4">
        <x-adminlte-small-box title="Fechamento Diário" text="Valor do estoque ao final dos dias"
        theme="primary" url="{{route('telaFechamentoDiario')}}"  />
    </div> --}}

    <div class="col-md-4">
        <x-adminlte-small-box title="Planilha" text="Baixar planilha com as Solicitações Criadas"
        theme="primary" url="{{route('exportaEstoque')}}"  />
    </div>

</div>
<div class="row">

    <div class="col-md-4">

        <x-adminlte-small-box title="{{$total}} " text="Total de Solicitações"
        theme="purple"    />

    </div>

{{--
    <div class="col-md-4">
        <x-adminlte-small-box title="" text="Total de Produtos"
        theme="purple"   />
    </div>
 --}}


</div>

<table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>Cód Requisição</th>
                <th>Cliente</th>
                <th>Tipo</th>
                <th>Data</th>
                <th>Solicitante</th>
                <th>Responsável</th>
                <th>Status</th>
                <th>Detalhes</th>

            </tr>
        </thead>
      <tbody>
            @foreach($pedidos as $pedido)
            <tr>
                <td>{{$pedido->id}}</td>
                <td>{{$pedido->nome}}</td>
                <td> {{$pedido->tipo}}</td>
                <td> {{ date('d/m/Y', strtotime($pedido->data)) }}</td>
                <td>{{$pedido->name}}</td>
                <td>{{$pedido->resp}}</td>
                <td>{{$pedido->status}}</td>
                <td> <a class="btn btn-success" href="{{route('detalheRequisicao', $pedido->id)}}">Detalhes</a> </td>
{{--

                <td> <a class="btn btn-success" href="{{route('detalheproduto', $produto->id)}}">Detalhes</a> </td>
                <td> <a class="btn btn-success" href="{{route('alteraproduto', $produto->id)}}">Alterar</a> </td>
                <td> <a class="btn btn-success" href="{{route('entradaproduto', $produto->id)}}">Nova Entrada</a> </td>
                <td> <a class="btn btn-success" href="{{route('saidaproduto', $produto->id)}}">Nova Saída</a> </td> --}}

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
        "order": [[0, 'desc']] // Aqui está a opção para ordenar pelo ID (primeira coluna) de forma descendente
    });
});
</script>

@endsection
