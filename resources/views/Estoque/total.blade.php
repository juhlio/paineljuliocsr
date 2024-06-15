@extends('adminlte::page')


@section('content')


<div class="card p-3 mb-3">

<div class="row">
    
    <div class="col-md-4">

    <x-adminlte-small-box title="R$ {{$totalEmEstoque}}" text="Custo Total do Estoque" icon="fas fa-plus text-white"
    theme="primary" url="{{route('novoprodutoestoque')}}" url-text="Adicionar Agora"/>
        
    </div>

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