@extends('adminlte::page')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<br>

<div class="card p-3 mb-3">

    <form name="formDatas" autocomplete="off">
        @csrf
        <div class="row">

            <div class="col-md-3">

                <x-adminlte-input-date name="datetimepicker" label="Data Inicial das Informações">
                    <x-slot name="appendSlot">
                    </x-slot>

                </x-adminlte-input-date>

            </div>

            <div class="col-md-3">

                <x-adminlte-input-date name="datetimepicker2" label="Data Final das Informações">
                    <x-slot name="appendSlot">
                    </x-slot>

                </x-adminlte-input-date>

            </div>

            <div class="col-md-3">
                <button class="btn btn-success" type="submit">Atualizar</button>
            </div>


        </div>
    </form>
    <div class="row">

        <div class="col-md-4">

            <x-adminlte-small-box title="R$ {{$saldoInicial}}" text="Valor Inicial" id='saldoInicial' theme="primary" />

        </div>


        <div class="col-md-4">
            <x-adminlte-small-box title="R$ {{$totalFinal}}" text="Total Final" id='totalFinal' theme="primary" />
        </div>

        <div class="col-md-4">
            <a href="{{route('exportaMovimentacoes', [$dataInicio, $dataFim])}}" id="baixaplanilha">
                <x-adminlte-small-box title="Planilha" text="Baixar planilha com dados atuais do estoque" theme="primary" id="baixaplanilha">

                </x-adminlte-small-box>
            </a>
        </div>

    </div>

    <div class="row">

        <div class="col-md-4">

            <x-adminlte-small-box title="R$  {{$totalEntradas}} " text="Total de Entradas" id='totalEntradas' theme="primary" />

        </div>

        <div class="col-md-4">
            <x-adminlte-small-box title="R$ {{$totalSaidas}} " text="Total de Saídas" id='totalSaidas' theme="primary" />
        </div>

        <div class="col-md-4">
            <x-adminlte-small-box title="R$ {{$saldo}}" text="Saldo Período" id="saldoMovimentacoes" theme="primary" />
        </div>



    </div>

    <hr>

    <div>
        <h4>Entradas</h4>


        <table id="example" class="hover" style="width:100%">
            <thead>
                <tr>

                    <th>Descrição</th>
                    <th>Fabricante</th>
                    <th>Tipo</th>
                    <th>EAN</th>
                    <th>Fornecedor/Cliente</th>
                    <th>NF</th>
                    <th>Quantidade</th>
                    <th>Estado</th>
                    <th>Tipo de Entrada</th>
                    <th>Custo</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entradas as $entrada )
                @if($entrada->novo == '1')
                @php($estado = "Novo")
                @else
                @php($estado = "Usado")
                @endif

                @if($entrada->tipoEntrada == '1')
                @php($tipo = "Compra")
                @elseif($entrada->tipoEntrada == '2')
                @php($tipo = "Devolução")
                @elseif($entrada->tipoEntrada == '3')
                @php($tipo = "Devolução de Obra")
                @endif



                <tr>
                    <td>{{$entrada->descricao}}</td>
                    <td>{{$entrada->fabricante}}</td>
                    <td>{{$entrada->tipo}}</td>
                    <td>{{$entrada->ean}}</td>
                    <td>{{$entrada->fornecedor}}</td>
                    <td>{{$entrada->nf}}</td>
                    <td>{{$entrada->quantidade}}</td>
                    <td>{{$estado}}</td>
                    <td>{{$tipo}}</td>
                    <td>R$ {{number_format($entrada->custo,2,",",".")}}</td>
                    <td>{{$entrada->data}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <hr>

    <div class="justify-content-center">
        <h4>Saídas</h4>
        <br>

        <table id="example1" class="hover" style="width:100%">
            <thead>
                <tr>

                    <th>Cliente</th>
                    <th>Quantidade</th>
                    <th>Estado</th>
                    <th>Data</th>
                    <th>Solicitante</th>
                </tr>
            </thead>
            <tbody>
                @foreach($saidas as $saida)
                @if($saida->estado == "1")
                @php($estado = "Novo")
                @else
                @php($estado = "Usado")
                @endif

                <tr>
                    <td>{{$saida->cliente}}</td>
                    <td>{{$saida->quantidade}}</td>
                    <td>{{$estado}}</td>
                    <td>{{$saida->data}}</td>
                    <td>{{$saida->solicitante}}</td>
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
        $(function() {
            $("#datetimepicker").datepicker({
                format: "dd/mm/yyyy",
                language: 'br'


            });
        });
    </script>

    <script>
        $(function() {
            $("#datetimepicker2").datepicker({
                format: "dd/mm/yyyy",
                language: 'br'


            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />
    <input type="text" class="form-control pull-right" id="datetimepicker">

    <script>
        $(document).ready(function() {
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
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
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
                }
            });
        });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>


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

    <script>
        function atualizar() {

            const dataInicio = $("#datetimepicker").val();
            const dataFim = $("#datetimepicker2").val();
            console.log('começou a função atualizar')

            let planDataInicio = dataInicio.replace(/\//g, "");
            let planDataFim = dataFim.replace(/\//g, "");

            let url = `https://painel.essencialenergia.com.br/exportamovimentacoes/${planDataInicio}/${planDataFim}`

            $.ajax({
                url: "atualizamovimentacoes",
                type: "GET",
                contentType: 'application/json',
                data: {
                    dataInicio: dataInicio,
                    dataFim: dataFim
                },


                success: function(data) {
                    // Atualize a página com a resposta
                    console.log('sucesso')
                    console.log(data)
                    $('#saldoInicial h3').text('R$ ' + data.saldoInicial);
                    $('#totalEntradas h3').text('R$ ' + data.totalEntradas);
                    $('#totalSaidas h3').text('R$ ' + data.totalSaidas);
                    $('#saldoMovimentacoes h3').text(data.saldo);
                    $('#totalFinal h3').text('R$ ' + (data.saldoFinal));
                    $('#baixaplanilha').attr('href', url);


                    let tabela = '<table id="example" class="hover"><thead><tr><th>Descrição</th><th>Fabricante</th><th>Tipo</th><th>Fornecedor/Cliente</th><th>NF</th><th>Quantidade</th><th>Estado</th><th>Tipo Entrada</th><th>Custo</th><th>Data</th></tr></thead><tbody>'
                    $.each(data.detalhesEntradas, function(index, movimentacao) {
                        tabela += '<tr><td>' + movimentacao.descricao + '</td><td>' + movimentacao.fabricante + '</td><td>' + movimentacao.tipo + '</td><td>' + movimentacao.fornecedor + '</td><td>' + movimentacao.nf + '</td><td>' + movimentacao.quantidade + '</td><td>' + movimentacao.novo + '</td><td>' + movimentacao.tipoEntrada + '</td><td>' + movimentacao.custo + '</td><td>' + movimentacao.data + '</td></tr>';
                    });

                    tabela += '</tbody></table>';
                    $('#example').html(tabela);

                    let tabela1 = '<table id="example1" class="hover"><thead><tr><th>Cliente</th><th>Quantidade</th><th>Estado</th><th>Data</th><th>Solicitante</th></tr></thead><tbody>';
                    $.each(data.detalhesSaidas, function(index, movimentacao) {
                        tabela1 += '<tr><td>' + movimentacao.cliente + '</td><td>' + movimentacao.quantidade + '</td><td>' + movimentacao.estado + '</td><td>' + movimentacao.data + '</td><td>' + movimentacao.solicitante + '</td></tr>';
                    });
                    tabela1 += '</tbody></table>';
                    $('#example1').html(tabela1);

                }
            });
        }
    </script>

    <script>
        $(function() {
            $('form[name="formDatas"]').submit(function(event) {
                event.preventDefault();
                atualizar();
            });
        });
    </script>


    @endsection
