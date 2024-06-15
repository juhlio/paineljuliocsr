
<h3>Oi, {{$solicitante->name}}</h3>
<p>Sua  requisição foi rejeitada:</p>

<strong>Cliente:</strong> {{$cliente->nome}}<br>
<br>

<hr>

<h3>Itens</h3>

@foreach($produtos as $item)
    <p>Item: {{$item->descricao}}</p>
    <p>Quantidade: {{$item->quantidade}}</p>
    <br>
@endforeach

<hr>

<p><strong>Motivo da Rejeição</strong>: {{$obs}}</p>





Obrigado,<br>
Essencial Energia

