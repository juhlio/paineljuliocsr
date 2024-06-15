@extends('adminlte::page')


@section('content')

<br><br>

<div class="row">

    <div class="col-md-4">

    <x-adminlte-small-box title="Filtro" text="Faça um filtro entre os resultados automáticos"
            theme="primary" url="{{route('filtrocnpj')}}" url-text="Filtrar"/>
    </div>

<div class="col-md-4">

        <x-adminlte-small-box title="{{$total}}" text="Buscados Automaticamente"
            theme="primary" url="{{route('homeProspecoes')}}" url-text=""/>
    </div>

    <div class="col-md-4">

        <x-adminlte-small-box title="Nova Busca" text="Buscar novos possíveis contatos" icon="fas fa-search-plus text-white"
            theme="primary" url="{{route('telabuscacnpj')}}" url-text="Buscar"/>
    </div>




</div>




<div class="card">
<br>
<h3>Contatos Recebidos</h3>

<table id="example" class="hover"  style="width:100%">
        <thead>
            <tr>

                <th>Empresa</th>
                <th>CNPJ</th>
                <th>Contato</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Tipo Contato</th>
                <th>Obs</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados as $dado)
            <tr>
                <td>{{$dado->nomeEmpresa}}</td>
                <td>{{$dado->cnpj}}</td>
                <td>{{$dado->nomeContato}}</td>
                <td>{{$dado->email}}</td>
                <td>{{$dado->telefone}}</td>
                <td>{{$dado->razaoContato}}</td>
                <td>{{$dado->obs}}</td>
                <td><a href="{{route('detalheContato', $dado->id)}}" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                <i class="fa fa-lg fa-fw fa-eye"></i>
                    </a></td>
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
