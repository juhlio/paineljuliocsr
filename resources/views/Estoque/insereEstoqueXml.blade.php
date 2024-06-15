@extends('adminlte::page')


@section('content_header')
<h4>Detalhes Entrada XML</h4>
@endsection


@section('content')



<div class="card p-3 mb-3">

    <form name="formDatas" autocomplete="off" action="{{ route('finalizaEntradaXml') }}" method="POST">
        @csrf


        <div class="row">
            <div class="col-md-12">
                <div class="form-inline">
                    <div class="form-group">
                        <label for="autocomplete" class="mr-2">Nome do Produto:</label>
                        <input type="text" class="form-control  mr-2" id="autocomplete" name="autocomplete" size=80>
                    </div>
                    <button type="button" class="btn btn-success mr-2 ml-2" onclick="adicionaProduto()">Adicionar</button>
                    <button type="button" class="btn btn-danger" onclick="limparUltimo()">Exclui última entrada</button>
                </div>
            </div>


        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="form-inline font-weight-bold">
                    <div class="form-group col-sm-2 m-3">
                        Produto
                    </div>
                    <div class="form-group m-2 col-sm-2 text-center">
                        Nota Fiscal
                    </div>
                    <div class="form-group m-2 col-sm-2">
                        Fornecedor
                    </div>
                    <div class="form-group m-2 col-sm-2">
                        Custo 
                    </div>
                    <div class="form-group m-2 col-sm-2">
                        Quantidade
                    </div>
                </div>
            </div>
        </div>

        @foreach($produtos as $produto)

        <div class="row">

            <div class="row">

                <div class="col-md-12">
                    <div class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control m-2" name="produto[]" readonly required>
                        </div>
                        <div class="form-group m-2 col-sm-2"> <!-- Ajuste da classe aqui -->
                            <x-adminlte-input name="nf[]" readonly value="{{$nf}}" fgroup-class="col-sm-12" />
                        </div>
                        <div class="form-group m-2 col-sm-2"> <!-- Ajuste da classe aqui -->
                            <x-adminlte-input name="fornecedor[]" readonly value="{{$fornecedor}}" fgroup-class="col-sm-12" />
                        </div>
                        <div class="form-group m-2 col-sm-2"> <!-- Ajuste da classe aqui -->
                            <x-adminlte-input name="custo[]" readonly value="{{$produto->custo}}" fgroup-class="col-sm-12" />
                        </div>
                        <div class="form-group m-2 col-sm-2"> <!-- Ajuste da classe aqui -->
                            <x-adminlte-input name="quantidade[]" readonly value="{{$produto->quantidade}}" fgroup-class="col-sm-12" />
                        </div>
                    </div>
                </div>



            </div>

        </div>



        <hr>
        @endforeach

        <br><br>
        <div id="buttons">
            <button class="btn btn-block btn-success" type="submit"><i class="fas fa-upload"></i> Finalizar Entrada </button>
            {{-- <a class="btn btn-success btn-block" href="{{route('detalhecliente', $cliente->id)}}">Finalizar Entrada</a>
            --}}
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
                maxNumberOfElements: 3
            },
            theme: "description"
        };
        $('#autocomplete').each(function() {
            $(this).easyAutocomplete(options);
        });
    });
</script>

<script>
    function adicionaProduto() {
        // Seleciona todos os campos de entrada de produtos
        let produtos = document.getElementsByName("produto[]");

        // Seleciona o valor do campo de entrada de busca de produtos
        let produtoSelecionado = document.getElementsByName("autocomplete")[0].value;

        // Itera sobre os campos de entrada de produtos e adiciona o valor do campo de busca ao primeiro campo vazio encontrado
        for (let i = 0; i < produtos.length; i++) {
            if (produtos[i].value === "") {
                produtos[i].value = produtoSelecionado;
                break;
            }
        }
    }
</script>


<script>
    function limparUltimo() {
        // Seleciona todos os campos de entrada de produtos
        let produtos = document.getElementsByName("produto[]");

        // Itera sobre os campos de entrada de produtos em ordem reversa e limpa o primeiro campo preenchido encontrado
        for (let i = produtos.length - 1; i >= 0; i--) {
            if (produtos[i].value !== "") {
                produtos[i].value = "";
                break;
            }
        }
    }
</script>

@endsection

@section('css')

<link href="{{ asset('vendor/autocomplete/easy-autocomplete.min.css')}}">
<link href="{{ asset('vendor/autocomplete/easy-autocomplete.themes.min.css')}}">

@endsection