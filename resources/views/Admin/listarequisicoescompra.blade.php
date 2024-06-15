@extends('adminlte::page')

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('error') }}
    </div>
@endif



@section('content')

    <br>

<div class="card p-3 mb-3">

<div class="row">

    <div class="col-md-4">

        <x-adminlte-small-box title="Total de Requisições" text="Com filtro por data"
        theme="primary"  url="{{route('telamovimentacoes')}}"  />

    </div>

    <div class="col-md-4">
        <x-adminlte-small-box title="Em Andamento" text="Valor do estoque ao final dos dias"
        theme="success" url="{{route('telaFechamentoDiario')}}"  />
    </div>

    <div class="col-md-4">
        <x-adminlte-small-box title="Rejeitadas" text="Baixar planilha com dados atuais do estoque"
        theme="danger" url="{{route('exportaEstoque')}}"  />
    </div>

</div>


<table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>Cód Requisição</th>
                <th>Cliente</th>
                <th>Tipo</th>
                <th>Data</th>
                <th>Status</th>
                <th>Detalhes</th>
            </tr>
        </thead>
         <tbody>
                    @foreach($requisicoes as $requisicao)
                    <tr>
                        <td>{{$requisicao->id}}</td>
                        <td>{{$requisicao->nome}}</td>
                        <td>{{$requisicao->tipo}}</td>
                        <td>{{ date('d/m/Y', strtotime($requisicao->created_at)) }}</td>
                        <td>{{$requisicao->status}}</td>
                        <td> <a class="btn btn-success" href="{{route('telaRequisicaoCompra', $requisicao->id)}}">Detalhes</a> </td>
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
        },
        "order": [[0, 'desc']] // Aqui está a opção para ordenar pelo ID (primeira coluna) de forma descendente

        
    });
});
</script>

@endsection
