@extends('adminlte::page')

@section('title', ' Novo Chamado')

@section('content_header')
<h1>Novo Chamado </h1>
@endsection

@section('content')

<form method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card p-3 mb-3">

        <div class="row">
            <div class="col-md">
                <label for="autocomplete" class="mr-2">Nome Cliente</label>
                <input type="text" class="form-control  mr-2" id="autocomplete" name="client" size=80>

            </div>

        </div>
        <br>

        <div class="row">

            <div class="col-md">
                <x-adminlte-input name="contactName" label="Nome Solicitante" fgroup-class="col-sm-12" />
            </div>


            <div class="col-md">
                <x-adminlte-input name="position" label="Cargo" fgroup-class="col-sm-12" />
            </div>

            <div class="col-md">
                <x-adminlte-input name="phone" label="Telefone" fgroup-class="col-sm-12" />
            </div>

        </div>

        <div class="row">
            <div class="col-md">
                <x-adminlte-textarea name="description" label="Descrição Chamado" />
            </div>

        </div>




        <br><br>
        <div id="buttons">
            <button class="btn btn-block btn-success" type="submit"><i class="fas fa-upload"></i> Enviar </button>
        </div>

</form>
</div>


@endsection

@section('css')

<link rel="stylesheet" type="text/css" href="{{ url('vendor/dropify/dropify.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">


@endsection


@section('js')

<script src="{{ asset('vendor/autocomplete/jquery.easy-autocomplete.min.js') }}" type="text/javascript"></script>
<script src="{{ url('vendor/autocomplete/jquery.easy-autocomplete.min.js')}}"></script>

<script src="{{ asset('vendor/autocomplete/jquery.easy-autocomplete.min.js') }}" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        var options = {
            url: "{{route('listaCli')}}",
            getValue: "name",
            list: {
                match: {
                    enabled: true
                },
                maxNumberOfElements: 5
            },
            theme: "description"
        };
        $('#autocomplete').each(function() {
            $(this).easyAutocomplete(options);
        });
    });

    function adicionaProduto() {
        let novoProdutoClone = document.querySelector(".novoProduto").cloneNode(true);
        let linhaDeProduto = document.querySelector("[name='linhaDeProduto']");
        novoProdutoClone.classList.remove("d-none");

        // Obtém o valor da div "autocomplete"
        let valorAutocomplete = document.getElementById("autocomplete").value;

        // Define o valor no campo "produto[]" do novo produto clonado
        let campoProduto = novoProdutoClone.querySelector("[name='produto[]']");
        campoProduto.value = valorAutocomplete;


        linhaDeProduto.appendChild(novoProdutoClone);

        //limpa o campo custo e o campo quantidade da linha clonada
        let campoCusto = novoProdutoClone.querySelector("[name='custo[]']");
        campoCusto.value = "";
        let campoQuantidade = novoProdutoClone.querySelector("[name='quantidade[]']");
        campoQuantidade.value = "";

        // Limpa o campo "autocomplete"
        document.getElementById("autocomplete").value = "";
    }
</script>

@endsection

@section('css')
<link href="{{ asset('vendor/autocomplete/easy-autocomplete.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendor/autocomplete/easy-autocomplete.themes.min.css')}}" rel="stylesheet">
@endsection