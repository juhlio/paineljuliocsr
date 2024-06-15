<table>
    <thead>
    <tr>
        <th>Código Atendimento</th>
        <th>Tipo</th>
        <th>Status</th>
        <th>Cliente</th>
        <th>Apelido</th>
        <th>Relato</th>
        <th>Data Atendimento</th>
        <th>Link Relatório</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tasks as $task)
        <tr>
            <td>{{ $task->auvoId}}</td>
            <td>{{ $task->type}}</td>
            <td>{{ strtoupper($task->statusFarol) }}</td>
            <td>{{$task->razaoSocial }}</td>
            <td>{{ $task->nome }}</td>
            <td>{{ $task->obs }}</td>
            <td> {{ \DateTime::createFromFormat('Y-m-d H:i:s', $task->taskDate)->format('d/m/Y') }}</td>
            <td> {{$task->osurl}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
