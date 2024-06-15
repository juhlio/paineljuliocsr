<table>
    <thead>
        <tr>
            <th>Codigo Produto</th>
            <th>Produto</th>
            <th>Fabricante</th>
            <th>Quantidade</th>
            <th>Estado</th>
            <th>Código Categoria</th>
            <th>Nome Categoria</th>
            <th>Data</th>
            <th>Fornecedor</th>
            <th>Custo Unitário</th>
            <th>Custo Total</th>
        </tr>
    </thead>
     <tbody>
     @foreach($entradas as $entrada)
     <tr>
        <td>{{ $entrada->idConsumiveis }}</td>
        <td>{{ $entrada->descricao }}</td>
        <td>{{ $entrada->fabricante }}</td>
        <td>{{ $entrada->quantidade }}</td>
        <td>{{ $entrada->estado }}</td>
        <td>{{ $entrada->idTipo }}</td>
        <td>{{ $entrada->nomeCategoria }}</td>
        <td>{{ $entrada->data }}</td>
        <td>{{ $entrada->fornecedor }}</td>
        <td>{{ $entrada->custo }}</td>
        <td>{{ $entrada->custo*$entrada->quantidade }}</td>
       
     </tr>
     @endforeach
    </tbody>
</table>