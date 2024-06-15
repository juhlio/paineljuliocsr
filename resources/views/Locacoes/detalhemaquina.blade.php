@extends('adminlte::page')

@section('title', ' Detalhes')

@section('content_header')
<h1></h1>
@endsection

@section('content')



<div class="card p-3 mb-3">

    <div class="row">

        <a class="btn btn-success p-3 mb-3 m-2" href="{{route('relatoriopm1', $id)}}">Nova Preventiva</a>
        <a class="btn btn-success p-3 mb-3 m-2" href="{{route('relatorioAtendimento', $id)}}">Novo Atendimento</a>
        <a class="btn btn-success p-3 mb-3 m-2" href="{{route('relatorioEntrega', $id)}}">Entrega</a>


    </div>




</div>

<div class="card p-3 mb-3">

    <div class="row">

        <div class="col-md">
            <strong> Fabricante Grupo:</strong> {{$dados->fabricanteEquipamento}} <br>
            <strong> Número Serie do Grupo: </strong> {{$dados->serieEquipamento}} <br>

            <br>


        </div>

        <div class="col-md">
            <strong> Data de Fabricação:</strong> {{$dados->dataFabricacao}} <br>
            <strong> Potência: </strong> {{$dados->potencia}} <br>
            <br>

        </div>


    </div>




    <hr>
    <div class="row">
        <div class="col-md">
            <strong> Fabricante Motor:</strong> {{$dados->fabricanteMotor}} <br>
            <strong> Modelo Motor:</strong> {{$dados->modeloMotor}} <br>
            <strong> Número Serie Motor: </strong> {{$dados->serieMotor}} <br>

        </div>


        <div class="col-md">
            <strong> Fabricante Alternador:</strong> {{$dados->fabricanteAlternador}} <br>
            <strong> Modelo Alternador:</strong> {{$dados->modeloAlternador}} <br>
            <strong> Número Alternador: </strong> {{$dados->serieAlternador}} <br>

        </div>





    </div>


    <hr>

    <div class="row">
        <div class="col-md">
            <strong> Quantidade Óleo Lubrificante:</strong> {{$dados->quantidadeOleoLubrificante}} <br>
        </div>

    </div>

    <hr>

    <div class="row">
        <div class="col-md">
            <h5>Filtro Combustivel</h5>
            <strong> Modelo:</strong> {{$dados->modeloFiltroCombustivel}} <br>
            <strong> Quantidade:</strong> {{$dados->quantidadeFiltroCombustivel}} <br>



        </div>

        <div class="col-md">
            <h5>Filtro Separador</h5>
            <strong> Modelo:</strong> {{$dados->modeloFiltroSeparador}} <br>
            <strong> Quantidade:</strong> {{$dados->quantidadeFiltroSeparador}} <br>

        </div>

        <div class="col-md">
            <h5>Filtro de Água</h5>
            <strong> Modelo:</strong> {{$dados->modeloFiltroAgua}} <br>
            <strong> Quantidade:</strong> {{$dados->quantidadeFiltroAgua}} <br>

        </div>

        <div class="col-md">
            <h5>Filtro de Óleo</h5>
            <strong> Modelo:</strong> {{$dados->modeloFiltroOleo}} <br>
            <strong> Quantidade:</strong> {{$dados->quantidadeFiltroOleo}} <br>


        </div>

        <div class="col-md">
            <h5>Filtro de Ar</h5>
            <strong> Modelo:</strong> {{$dados->modeloFiltroAr}} <br>
            <strong> Quantidade:</strong> {{$dados->quantidadeFiltroAr}} <br>

        </div>


    </div>

    <hr>


    <div class="row">
        <div class="col-md">
            <h5>Módulo do Grupo</h5>
            <strong> Fabricante:</strong> {{$dados->fabricanteModulo}} <br>
            <strong> Modelo:</strong> {{$dados->modeloModulo}} <br>


            <br>


            <br><br>

        </div>


        <hr>


    </div>

    <hr>

    @if($imagens)

    <div class="filter-container p-0 row">


        @foreach($imagens as $imagem)

        <div class="filtr-item col-md-2" data-category="1">
            <a href="{{ URL::asset('assets/images/clients/'.$imagem->url) }}" data-toggle="lightbox" data-title="{{ $imagem->posicao }}" data-footer='<a href="{{ route("excluiImagem", $imagem->id ) }}" class="btn btn-danger btn-sm excluir-imagem">Excluir</a>'>
                <img src="{{ URL::asset('assets/images/clients/'.$imagem->url) }}" class="img-fluid mb-2" alt="{{ $imagem->posicao }}" />
            </a>
        </div>


        @endforeach
    </div>


    @endif

    <a class="btn btn-success" href="{{route('telaInsereImagens', $id)}}">Inserir Fotos</a>



    <br><br>
    <div id="buttons">
    </div>




</div>


@endsection


@section('css')

<link rel="stylesheet" type="text/css" href="{{ url('vendor/dropify/dropify.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
<link rel="stylesheet" href="{{url('vendor/autocomplete/easy-autocomplete.min.css')}}">
<link rel="stylesheet" href="{{url('vendor/autocomplete/easy-autocomplete.themes.min.css')}}">


@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script src="{{ url('vendor/autocomplete/jquery.easy-autocomplete.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"> </script>

<script>
    $('.dropify').dropify({
        messages: {
            'default': 'Insira a Imagem',
            'replace': 'Arraste e solte ou clique para trocar a imagem',
            'remove': 'Remover',
            'error': 'Ooops, algo errado aconteceu.'
        }
    });
</script>

<script>
    $(function() {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

        $('.filter-container').filterizr({
            gutterPixels: 3
        });
        $('.btn[data-filter]').on('click', function() {
            $('.btn[data-filter]').removeClass('active');
            $(this).addClass('active');
        });
    })
</script>



@endsection
