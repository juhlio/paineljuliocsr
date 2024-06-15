@extends('adminlte::page')



@section('content_header')
<h1>Detalhes do Chamado {{$call->id}} </h1>
@endsection

@section('content')

<div class="card p-3 mb-3">

    <div class="row">
        <div class="col-md">
            <strong> Cliente: </strong> {{$call->name}} <br>
            <strong> Solicitante: </strong> {{$call->contactName}} <br>
            <strong> Cargo: </strong> {{$call->position}} <br>
            <strong> Telefone: </strong> {{$call->phone}}<br>
        </div>

    </div>


    <hr>

    <div class="row">
        <div class="col-md">
            <strong> Descrição: </strong> <br>
            {{$call->description}}

        </div>

    </div>


    <br><br>

    @if($serviceOrder)

    <div class="row">
        <div class="col-md">
            <strong>Ordem de Serviço: </strong> {{$serviceOrder->id}} <br>
            <strong>Status: </strong> {{$serviceOrder->status}} <br>
            <strong>Aberta em: </strong> {{$serviceOrder->created_at}} <br>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md d-flex align-items-center">
            <strong class="mr-2">Atendimento: </strong> {{$serviceReport->id}}
            <a class="btn btn-success ml-5" href="{{route('atendimentoChamado', $serviceReport->id)}}"><i class="fas fa-eye"></i></a>
        </div>
    </div>

    @else
    <div>
        <a class="btn btn-success" href="{{route('novaOrdemServico', $call->id)}}"><i class="fas fa-upload"></i> Cria Ordem de Serviço </a>
    </div>
    @endif

    <br><br>


</div>


@endsection