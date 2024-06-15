
<h3>Oi, </h3>

<p>Foi criada uma nova requisição para compras:</p>

<strong>Cliente:</strong> {{$nomeCliente->nome}}<br>
<strong>Tipo: </strong>  {{$nomeTipo}} <br>
<strong>Solicitante: </strong> {{$nomeSolicitante->name}} <br>

<br>

<hr>
<h3>Itens</h3>

@foreach($produtos as $item)
    <p>Item: {{$item->descricao}}</p>
    <p>Quantidade: {{$item->quantidade}}</p>
    <br>
@endforeach

<hr>



Obrigado,<br>
Essencial Energia

