
<h3>Oi, {{$nomeSolicitante->name}}</h3>
<p>Veja os detalhes da requisição que você acabou de criar:</p>

<strong>Cliente:</strong> {{$nomeCliente->nome}}<br>
<strong>Tipo: </strong>  {{$nomeTipo}} <br>
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

