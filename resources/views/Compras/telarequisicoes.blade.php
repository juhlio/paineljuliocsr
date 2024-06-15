@extends('adminlte::page')


@section('content_header')
<h4>Requisição para Setor de Compras</h4>
@endsection


@section('content')

@if (session('success'))
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    {{ session('success') }}
</div>
@endif


<div class="card p-3 mb-3">

    <form name="formDatas" autocomplete="off" action="{{ route('telaRequisicoes') }}" method="POST">
        @csrf

        <div class="row">

            <div class="col-md-4 clientes-wrapper">
                <label for="clientes" class="control-label">Cliente</label>
                <input type="text" class="form-control mr-2" id="clientes" name="cliente" label="Cliente" required style="width: 100% !important;">
            </div>


            <div class="col-md-4">
                <x-adminlte-input-date name="datetimepicker" required label="Data" readonly value="{{ now()->format('d/m/Y') }}">
                    <x-slot name="appendSlot"></x-slot>
                </x-adminlte-input-date>
            </div>


            <div class="col-md-4">
                <x-adminlte-select name="tipo" label="Tipo de Solicitação" igroup-size="md">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info"></div>
                    </x-slot>
                    <option>Orçamento</option>
                    <option>Compra</option>
                    <option>Separação</option>
                </x-adminlte-select>
            </div>




        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-inline">
                    <div class="form-group">
                        <label for="autocomplete" class="mr-2">Nome do Produto ou Serviço:</label>
                        <input type="text" class="form-control mr-2" id="autocomplete" name="autocomplete">
                    </div>
                    <button type="button" class="btn btn-success mr-2 ml-2" onclick="adicionaProduto()">Adicionar</button>
                    <button type="button" class="btn btn-danger" onclick="limparUltimo()">Exclui Última Entrada</button>
                </div>
            </div>
        </div>




        <div name="linhaDeProduto">


        </div>

        <div class="novoProduto d-none" name="novoProduto">
            <br>
            <div class="col-md-12">
                <div class="form-inline">
                    <div class="form-group col-md-6">
                        <label for="produto">Produto: </label>
                        <input type="text" class="form-control m-2" name="produto[]" style="width: 80% !important;" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="quantidade">Quantidade:</label>
                        <input type="text" class="form-control m-2" name="quantidade[]" required>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-md">
                    <x-adminlte-textarea name="obs[]" label="Descrição do Serviço/Produto ou uma Observação" fgroup-class="col-sm-12" />
                </div>
            </div>


        </div>


        <br><br>

        <div id="buttons">
            <button class="btn btn-block btn-success" type="submit"><i class="fas fa-upload"></i> Finalizar Pedido </button>
        </div>


    </form>
</div>
@endsection

@section('js')

<script src="{{ asset('vendor/autocomplete/jquery.easy-autocomplete.min.js') }}" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        var options = {
            url: "{{route('listaProdutos')}}",
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
        $('#clientes').each(function() {
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

        // Limpa o campo "autocomplete"
        document.getElementById("autocomplete").value = "";
    }
</script>

<script>
    function limparUltimo() {
        // Seleciona todas as divs com o nome "novoProduto"
        let divs = document.getElementsByName("novoProduto");

        // Verifica se há alguma div para remover
        if (divs.length > 1) {
            // Obtém a última div e a remove
            let ultimaDiv = divs[divs.length - 1];
            ultimaDiv.parentNode.removeChild(ultimaDiv);
        }
    }
</script>

@endsection

@section('css')
<link href="{{ asset('vendor/autocomplete/easy-autocomplete.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendor/autocomplete/easy-autocomplete.themes.min.css')}}" rel="stylesheet">
<style>
    .clientes-wrapper .form-control {
        width: 100%;
    }
</style>
@endsection