@extends('adminlte::page')

@section('title', 'Revisão de Cadastro')

@section('content_header')
<h1>Cadastro Equipamento</h1>
@endsection

@section('content')


<form method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="nf" label="NF" placeholder="" fgroup-class="col-md-12" />
        </div>

        <div class="col-md">
            <x-adminlte-input name="valorNota" label="Valor Nota" placeholder="" fgroup-class="col-md-12" />
        </div>

        <div class="col-md">
            <x-adminlte-input name="dataNota" label="Data Nota Fiscal" placeholder="Formato dd/mm/aaaa" fgroup-class="col-md-12" />
        </div>

    </div> {{--Fechamento row--}}


    <div class="row">

        <div class="col-sm-6">

            <x-adminlte-select name="empresaCompra" label="Empresa Responsavel pela Compra" igroup-size="md col-6">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-info">
                    </div>
                </x-slot>
                <option>Essencial</option>
                <option>Iron</option>
                <option>Carfag</option>
            </x-adminlte-select>

        </div>


        <div class="col-sm-6">

            <x-adminlte-select name="classificacaoFiscal" label="Classificação Fiscal" igroup-size="md col-6">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-info">
                    </div>
                </x-slot>
                <option></option>
                <option>Ativo</option>
                <option>Revenda</option>
            </x-adminlte-select>

        </div>


    </div> {{--Fechamento row--}}

    <div class="row">

        <div class="col-sm-6">

            <x-adminlte-select name="tipoEquipamento" label="Tipo de Equipamento" igroup-size="md col-6">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-info">
                    </div>
                </x-slot>
                <option>GMG Aberto</option>
                <option>GMG Carenado</option>
            </x-adminlte-select>

        </div>

        {{-- fechamento row --}}
    </div>


    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="fabricanteEquipamento" label="Fabricante do Equipamento" placeholder="Digite o Fabricante" fgroup-class="col-md-12" />
        </div>


        <div class="col-md">
            <x-adminlte-input name="serieEquipamento" label="Número de Série do Equipamento" required placeholder="Digite o numero de série" fgroup-class="col-md-12" />
        </div>



    </div> {{--Fechamento row--}}


    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="potencia" label="Potência" placeholder="" fgroup-class="col-md-12" />
        </div>

        <div class="col-md">
            <x-adminlte-input name="dataFabricacao" label="Data de Fabricação" placeholder="" fgroup-class="col-md-12" />
        </div>

    </div> {{--Fechamento row--}}









    <h4>Motor</h4>

    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="fabricanteMotor" label="Fabricante do Motor" placeholder="" fgroup-class="col-md-12" />
        </div>

        <div class="col-md">
            <x-adminlte-input name="modeloMotor" label="Modelo do Motor" placeholder="" fgroup-class="col-md-12" />
        </div>


    </div> {{--Fechamento row--}}

    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="serieMotor" label="Número de Série do Motor" placeholder="" fgroup-class="col-md-12" />
        </div>




    </div> {{--Fechamento row--}}

    <hr>

    <h4>Alternador</h4>

    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="fabricanteAlternador" label="Fabricante do Alternador" placeholder="" fgroup-class="col-md-12" />
        </div>

        <div class="col-md">
            <x-adminlte-input name="modeloAlternador" label="Modelo do Alternador" placeholder="" fgroup-class="col-md-12" />
        </div>


    </div> {{--Fechamento row--}}

    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="serieAlternador" label="Número de Série do Alternador" placeholder="" fgroup-class="col-md-12" />
        </div>




    </div> {{--Fechamento row--}}

    <hr>

    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="quantidadeOleo" label="Quantidade de Óleo Lubrificante" placeholder="" fgroup-class="col-md" />
        </div>

    </div> {{--Fechamento row--}}

    <hr>

    <h4>Filtro de Combustível</h4>
    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="modeloFiltroCombustivel" label="Modelo Filtro de Combustível" placeholder="" fgroup-class="col-md-12" />
        </div>
        <div class="col-md">
            <x-adminlte-input name="quantidadeFiltroCombustivel" label="Quantidade Filtro de Combustível" placeholder="" fgroup-class="col-md-12" />
        </div>



    </div> {{--Fechamento row--}}

    <hr>

    <h4>Filtro Separador</h4>
    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="modeloFiltroSeparador" label="Modelo Filtro Separador" placeholder="" fgroup-class="col-md-12" />
        </div>
        <div class="col-md">
            <x-adminlte-input name="quantidadeFiltroSeparador" label="Quantidade Filtro Separador" placeholder="" fgroup-class="col-md-12" />
        </div>



    </div> {{--Fechamento row--}}

    <hr>

    <h4>Filtro de Água</h4>
    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="modeloFiltroAgua" label="Modelo Filtro de Água" placeholder="" fgroup-class="col-md-12" />
        </div>
        <div class="col-md">
            <x-adminlte-input name="quantidadeFiltroAgua" label="Quantidade Filtro de Água" placeholder="" fgroup-class="col-md-12" />
        </div>



    </div> {{--Fechamento row--}}

    <hr>


    <h4>Filtro de Óleo</h4>
    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="modeloFiltroOleo" label="Modelo Filtro de Óleo" placeholder="" fgroup-class="col-md-12" />
        </div>
        <div class="col-md">
            <x-adminlte-input name="quantidadeFiltroOleo" label="Quantidade Filtro de Óleo" placeholder="" fgroup-class="col-md-12" />
        </div>



    </div> {{--Fechamento row--}}

    <hr>

    <h4>Filtro de Ar</h4>
    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="modeloFiltroAr" label="Modelo Filtro de Ar" placeholder="" fgroup-class="col-md-12" />
        </div>
        <div class="col-md">
            <x-adminlte-input name="quantidadeFiltroAr" label="Quantidade Filtro de Ar" placeholder="" fgroup-class="col-md-12" />
        </div>



    </div> {{--Fechamento row--}}




    <hr>

    <h4>Módulos</h4>

    <div class="row">

        <div class="col-md">
            <x-adminlte-input name="fabricanteModulo" label="Fabricante do Módulo do Grupo" placeholder="" fgroup-class="col-md-12" />
        </div>

        <div class="col-md">
            <x-adminlte-input name="modeloModulo" label="Modelo do Módulo do Grupo" placeholder="" fgroup-class="col-md-12" />
        </div>


    </div> {{--Fechamento row--}}






    </div> {{--Fim da Row--}}
    <br><br>
    <div id="buttons">
        <button class="btn btn-block btn-success" id="concluir" type="submit"><i class="fas fa-upload"></i> Enviar </button>
    </div>

</form>



@endsection {{-- fechamento da section content --}}

@section('css')

<link rel="stylesheet" type="text/css" href="{{ url('vendor/dropify/dropify.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
<link rel="stylesheet" href="{{url('vendor/autocomplete/easy-autocomplete.min.css')}}">
<link rel="stylesheet" href="{{url('vendor/autocomplete/easy-autocomplete.themes.min.css')}}">


@endsection


@section('js')

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
    function getDadosProduto(cliente) {
        let url = 'client/' + cliente

        let xmlHttp = new XMLHttpRequest()
        xmlHttp.open('GET', url)

        xmlHttp.onreadystatechange = () => {
            if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                let dadosJSONText = xmlHttp.responseText
                let dadosJSONObj = JSON.parse(dadosJSONText)


                document.getElementById('id_cliente').value = dadosJSONObj.id




            }
        }

        xmlHttp.send()
    }
</script>

<!--Função autocomplete-->

<script>
    var options = {
        url: "clients",

        getValue: "name",


        list: {
            match: {
                enabled: true
            }
        }
    };

    $("#cliente").easyAutocomplete(options);
</script>
@endsection
