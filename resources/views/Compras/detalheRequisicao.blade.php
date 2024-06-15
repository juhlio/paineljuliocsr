@extends('adminlte::page')

@section('title', 'Requisição')

@section('content_header')
<h4>Requisição N.º {{$id}} </h4>
@endsection

@section('content')

<div class="card p-3 mb-3">
    <div class="row">
        <div class="col-md">
            <strong>Cliente:</strong> {{$detail->nome}} <br>
            <strong>Data:</strong> {{ date('d/m/Y', strtotime($detail->data)) }} <br>
            <strong>Tipo Solicitação:</strong> {{$detail->tipo}} <br>
            <strong>Status:</strong> {{$detail->status}} <br>
            <strong>Responsável:</strong> {{$detail->resp}}
        </div>
    </div>

    <hr>
    @if($products)
    <div class="container bg-light text-center pt-3">
        <h4>Itens da Requisição</h4>
        <div class="row">
            <div class="col-md-2 text-center">
                <strong>Produto/Serviço</strong>
            </div>
            <div class="col-md-2 text-center">
                <strong>Quantidade</strong>
            </div>
            <div class="col-md-2 text-center">
                <strong>Valor Orçamento</strong>
            </div>
            <div class="col-md-4 text-center">
                <strong>Obs</strong>
            </div>
        </div>


        @foreach($products as $product)
        <br>
        <div class="row" id="{{$product->id}}">
            <div class="d-none">
                {{$product->produto}}
            </div>
            <div class="col-md-2 text-center">
                @if ($product->produtoCadastrado === 'Sim') {{$product->descricaoProduto->descricao}}
                @else {{$product->descricao}} @endif
            </div>
            <div class="col-md-2 text-center">
                {{$product->quantidade}}
            </div>
            <div class="col-md-2 text-center">
                @if($product->precoOrcamento == null)

                <div class="form-group m-2 text-center">
                    <input type="text" class="form-control" name="custo" placeholder="Custo">
                </div>

                @else

                R$ {{number_format($product->precoOrcamento, 2, ',', '.')}}

                @endif

            </div>
            <div class="col-md-3 text-center">
                @if($product->obs) {{$product->obs}}

                @else
                <div class="form-group m-2">
                    <input type="text" class="form-control" name="obslinhaproduto" placeholder="Obs">
                </div>
                @endif
            </div>

            <div class="col-md-1 text-center">
                <button class="btn btn-success" type="button">
                    <i class="fa fa-save"></i> <!-- Ícone de disquete, você pode substituir pela classe de ícone que preferir -->
                </button>
            </div>

        </div>

        @endforeach
    </div>
    @endif
    <br>
    <hr>

    <div class="row">
        <div class="col-md">
            <form class="form-inline" method="POST" action="{{ route('selecionaresponsavel', $id) }}">
                @csrf
                <div class="form-group mr-2">
                    <label for="responsavel" class="mr-2">Responsável:</label>
                    <select class="form-control" id="responsavel" name="responsavel">
                        <option value="Gustavo">Gustavo</option>
                        <option value="Luiz">Luiz</option>
                        <option value="Yuri">Yuri</option>
                    </select>
                </div>
                <button class="btn btn-success" type="submit"><i class="fas fa-user"></i> Selecionar Responsável </button>
            </form>
        </div>
    </div>


    <hr>

    <div class="row">
        <div class="col-md">
            <h3>Histórico</h3>
            <br>
            @if($observacoes)
            @foreach($observacoes as $observacao)
            <strong>{{\Carbon\Carbon::parse($observacao->created_at)->format('d/m/Y H:i:s')}}</strong> - {{$observacao->obs}} <br>
            @endforeach
            @endif
            <strong>{{\Carbon\Carbon::parse($detail->created_at)->format('d/m/Y H:i:s')}} </strong> - Requisição Criada <br>
        </div>

        <div class="col-md">
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <x-adminlte-textarea name="obs" placeholder="Adicione uma Observação" />

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="enviarEmail" name="enviar_email">
                    <label class="form-check-label" for="enviarEmail">Enviar via e-mail</label>
                </div>

                <div class="row justify-content-center">
                    <div id="buttons">
                        <button class="btn btn-block btn-success" type="submit"><i class="fas fa-upload"></i> Salvar </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <hr>
    <br>

    <div class="row justify-content-center">
        <a class="btn btn-danger mr-3" href="{{route('telaCompras')}}">Voltar</a>
        <!-- Botão para acionar o pop-up (modal) -->
        <button class="btn btn-primary" data-toggle="modal" data-target="#alterarStatusModal">Rejeitar Requisição</button>
    </div>

</div>

<!-- Modal para alterar o status -->
<div class="modal fade" id="alterarStatusModal" tabindex="-1" role="dialog" aria-labelledby="alterarStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alterarStatusModalLabel">Rejeitar Requisição</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('rejeitarequisicao', $id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="observacao_status">Motivo Rejeição:</label>
                        <textarea class="form-control" id="observacao_status" name="obs" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Mudança de Status</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
    $(document).ready(function() {
        // Função para lidar com o clique no ícone
        $(".btn-success").click(function() {
            // Encontrar o ID da linha atual
            var rowId = $(this).closest(".row").attr("id");

            // Encontrar o campo de custo dentro da mesma linha
            var custoInput = $(this).closest(".row").find('[name="custo"]');

            // Encontrar o campo de observação dentro da mesma linha
            var obsInput = $(this).closest(".row").find('[name="obslinhaproduto"]');

            let custoVal = custoInput.val();
            let obsVal = obsInput.val();

            console.log(custoVal);
            console.log(obsVal)

          //Ajax para enviar os dados para o servidor
            $.ajax({
                url: "{{ route('atualizaValorRequisicao') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: rowId,
                    custo: custoVal,
                    obs: obsVal
                }
            }).done(function() {
                //recarregar a pagina
                location.reload();
            });
            
        
        });
    });
</script>




@endsection