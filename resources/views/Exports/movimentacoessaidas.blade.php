
<table>
    <thead>
        <tr>
            <th>Codigo Produto</th>
            <th>Produto</th>
            <th>Código Categoria</th>
            <th>Nome Categoria</th>
            <th>Quantidade</th>
            <th>Estado</th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Solicitante</th>
        </tr>
    </thead>
     <tbody>
     @foreach($saidas as $saida)
     <tr>
        <td>{{ $saida->idConsumiveis }}</td>
        <td>{{ $saida->descricao }}</td>
        <td>{{ $saida->idTipo }}</td>
        <td>{{ $saida->nomeCategoria }}</td>
        <td>{{ $saida->quantidade }}</td>
        <td>{{ $saida->estado }}</td>
        <td>{{ $saida->data }}</td>
        <td>{{ $saida->cliente }}</td>
        <td>{{ $saida->solicitante }}</td>
     </tr>
     @endforeach
    </tbody>
</table>