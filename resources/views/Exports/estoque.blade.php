<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Descrição</th>
        <th>Fabricante</th>
        <th>Tipo</th>
        <th>Código Fabricante</th>
        <th>Código EAN</th>
        <th>NCM</th>
        <th>Unidade Medida</th>
        <th>Localização</th>
        <th>Total Em Estoque</th>
        <th>Custo Última Compra</th>
        <th>Custo em Estoque</th>
    </tr>
    </thead>
    <tbody>
    @foreach($produtos as $produto)
        <tr>
            <td>{{ $produto->id }}</td>
            <td>{{ $produto->descricao }}</td>
            <td>{{ $produto->fabricante }}</td>
            <td>{{ $produto->tipo }}</td>
            <td>{{ $produto->codFabricante }}</td>
            <td>{{ $produto->codEan }}</td>
            <td>{{ $produto->ncm }}</td>
            <td>{{ $produto->unidadeMedida }}</td>
            <td>{{ $produto->localizacao }}</td>
            <td>{{ $produto->totalEstoque }}</td>
            <td>{{ $produto->ultimoCusto }}</td>
            <td>{{ $produto->totalEstoque * $produto->ultimoCusto }}</td>
        </tr>
    @endforeach
    </tbody>
</table>