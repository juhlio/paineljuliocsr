@extends('adminlte::page')
@section('title', 'Farol')
@section('content')

<br>

<div class="card p-3 mb-3">

    <form name="formDatas" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-md-3 mb-3">
                <x-adminlte-input-date name="datetimepicker" placeholder="Data Inicial das Informações">
                    <x-slot name="appendSlot">
                    </x-slot>
                </x-adminlte-input-date>
            </div>

            <div class="col-md-3 mb-3">
                <x-adminlte-input-date name="datetimepicker2" placeholder="Data Final das Informações">
                    <x-slot name="appendSlot">
                    </x-slot>
                </x-adminlte-input-date>
            </div>

            <div class="col-md-3 mb-3">
                <button class="btn btn-success btn-block" type="submit">Atualizar</button>
            </div>

            <div class="col-md-3 mb-3">
                <button class="btn btn-primary btn-block">Baixar</button>
            </div>
        </div>


    </form>

    <div class="row">



        <div class="col-md-4">
            <x-adminlte-small-box title="{{$totalVermelho}}" text="Inoperante" id="farolVermelho" theme="danger" />
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box title="{{$totalAmarelo}}" text="Operando com restrição" id="farolAmarelo" theme="warning" />
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box title="{{$totalVerde}}" text="Operando Normalmente" id="farolVerde" theme="success" />
        </div>

    </div>

    <p id="atualizandoInfo"></p>

    <table id="example" class="hover" style="width:100%">
        <thead>
            <tr>

                <th>Atendimento</th>
                <th>Tipo</th>
                <th>Data</th>
                <th>Status</th>
                <th>Cliente</th>
                <th>Apelido</th>
                <th>Relato</th>


            </tr>
        </thead>
        <tbody>

            @foreach ($tasks as $task)

            @if(mb_strtolower($task->statusFarol, 'UTF-8') == 'operando normalmente')
            <tr class="bg-success">
                @elseif(mb_strtolower($task->statusFarol, 'UTF-8') == 'operando com restrição')
            <tr class="bg-warning">
                @elseif (mb_strtolower($task->statusFarol, 'UTF-8') == 'inoperante')
            <tr class="bg-danger">
                @endif


                <td> <a href="https://app2.auvo.com.br/relatorioTarefas/DetalheTarefa/{{$task->auvoId}}" style="color: inherit; text-decoration: none;" target="_blank"> {{$task->auvoId}} </a> </td>
                <td> {{$task->type}}</td>
                <td> {{ \DateTime::createFromFormat('Y-m-d H:i:s', $task->taskDate)->format('d/m/Y') }}</td>
                <td> {{ ucfirst($task->statusFarol) }}</td>
                <td> {{$task->razaoSocial}}</td>
                <td>{{$task->nome}}</td>
                <td>{{$task->obs}}</td>


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
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.js"> </script>

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
            },
            "columnDefs": [{
                "targets": [0], // Defina a primeira coluna como data
                "type": "date-eu" // Especifique o tipo de data (formato europeu)
            }],
            "order": [
                [0, "desc"] // Defina a ordem inicial pela primeira coluna (data)
            ],
            responsive: true
        });
    });
</script>
<script>
    function atualizar() {
        const dataInicio = $("#datetimepicker").val();
        const dataFim = $("#datetimepicker2").val();
        console.log('começou a função atualizar');

        // Adicionar o texto "Atualizando informações"
        $('#atualizandoInfo').text("Atualizando informações...");

        let planDataInicio = dataInicio.replace(/\//g, "");
        let planDataFim = dataFim.replace(/\//g, "");



        $.ajax({
            url: "filtro/atualizafiltro",
            type: "GET",
            contentType: 'application/json',
            data: {
                dataInicio: dataInicio,
                dataFim: dataFim
            },
            success: function(data) {
                // Remover o texto "Atualizando informações" após os dados serem carregados
                $('#atualizandoInfo').empty();

                // Atualize a página com a resposta
                console.log('sucesso');
                console.log(data);
                $('#farolVermelho h3').text(data.totalVermelho);
                $('#farolAmarelo h3').text(data.totalAmarelo);
                $('#farolVerde h3').text(data.totalVerde);
                $('#totalEntradas h3').text('R$ ' + data.totalEntradas);
                $('#totalSaidas h3').text('R$ ' + data.totalSaidas);
                $('#saldoMovimentacoes h3').text(data.saldo);
                $('#totalFinal h3').text('R$ ' + (data.saldoFinal));
                $('#baixaplanilha').attr('href', url);

                let tabela = '<table id="example" class="hover"><thead><tr><th>Atendimento</th><th>Data</th><th>Status</th><th>Cliente</th><th>Apelido</th><th>Relato</th></tr></thead><tbody>';
                $.each(data.tasks, function(index, movimentacao) {
                    let trClass;
                    if (movimentacao.statusFarol.toLowerCase() == 'operando normalmente') {
                        trClass = "bg-success";
                    } else if (movimentacao.statusFarol.toLowerCase() == 'atenção') {
                        trClass = "bg-warning";
                    } else {
                        trClass = "bg-danger";
                    }

                    tabela += '<tr class="' + trClass + '"><td>' + movimentacao.auvoId + '</td><td>' + movimentacao.dataAtendimento + '</td><td>' + movimentacao.statusFarol.toUpperCase() + '</td><td>' + movimentacao.razaoSocial + '</td><td>' + movimentacao.nome + '</td><td>' + movimentacao.obs + '</td></tr>';
                });

                tabela += '</tbody></table>';
                $('#example').html(tabela);
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

<script>
    $(function() {
        // Função para lidar com o clique no botão "Baixar"
        $('button.btn-primary').click(function(event) {
            event.preventDefault(); // Evita o comportamento padrão do formulário

            const dataInicio = $("#datetimepicker").val();
            const dataFim = $("#datetimepicker2").val();

            // Construir a URL com os parâmetros
            let url = `filtro/baixar?dataInicio=${dataInicio}&dataFim=${dataFim}`;

            // Redirecionar para a URL de download
            window.location.href = url;
        });
    });
</script>


@endsection
