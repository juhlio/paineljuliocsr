@extends('adminlte::page')


@section('content_header')
<h4>Entrada em Lote</h4>
@endsection


@section('content')
<div class="card p-3 mb-3">

    <form name="formDatas" autocomplete="off" action="{{ route('telaRetorno') }}" method="POST">
        @csrf

        <div class="row">

            <div class="col-md-3">
                <x-adminlte-input name="fornecedor" label="Fornecedor/Cliente" required fgroup-class="col-sm-12" />
            </div>


            <div class="col-md-3">
                <x-adminlte-input name="nf" label="NF" fgroup-class="col-sm-12" />
            </div>

            <div class="col-md-3">
                <x-adminlte-input-date name="datetimepicker" required label="Data">
                    <x-slot name="appendSlot"></x-slot>
                </x-adminlte-input-date>
            </div>

        </div>

        <hr>

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

        <br>




        <div name="linhaDeProduto"></div>

        <div class="novoProduto d-none" name="novoProduto">


            <div class="row">

                <div class="col-md-12">
                    <div class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control m-2" name="produto[]" readonly required>
                        </div>
                        <div class="form-group m-2">
                            <x-adminlte-select name="estadoProduto[]" igroup-size="md">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-gradient-success"></div>
                                </x-slot>
                                <option>Novo</option>
                                <option>Usado</option>
                            </x-adminlte-select>
                        </div>
                        <div class="form-group m-2">
                            <x-adminlte-select name="tipoEntrada[]" igroup-size="md">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text  bg-gradient-success"></div>
                                </x-slot>
                                <option>Compra</option>
                                <option>Devolução</option>
                                <option>Retorno de Obra</option>
                            </x-adminlte-select>
                        </div>
                        <div class="form-group m-2">
                            <input type="text" class="form-control" name="custo[]" placeholder="Custo">
                        </div>
                        <div class="form-group m-2">
                            <input type="text" class="form-control" name="quantidade[]" placeholder="Quantidade">
                        </div>
                    </div>
                </div>



            </div>


        </div>


        <br><br>

        <div id="buttons">
            <button class="btn btn-block btn-success" type="submit"><i class="fas fa-upload"></i> Finalizar Entrada </button>
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

<script>
    $(document).keyup(function(e) {
        if (e.keyCode == 44) {
            navigator.clipboard.writeText('');
            alert('Não é possivel printar essa tela')
        }

    });


    /** TO DISABLE PRINTS WHIT CTRL+P **/
    document.addEventListener('keydown', (e) => {
        if (e.ctrlKey && e.key == 'p') {
            alert('This section is not allowed to print or export to PDF');
            e.cancelBubble = true;
            e.preventDefault();
            e.stopImmediatePropagation();
        }
    });
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
@endsection