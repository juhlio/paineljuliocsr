<?php

namespace App\Exports;

use App\Models\Questionarie;
use App\Models\Task;
use App\Models\Client;


use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FarolExport implements FromView
{
    public function view(): View
    {
        $clientsId = Task::select('clientId')->distinct()->get();


        $tasks = [];

        //loop para passar por todos os clientes
        foreach ($clientsId as $clientId) {

            //buscar última data de atendimento
            $lastDate = Task::select('created_at')
                ->where('clientId', '=', $clientId->clientId)
                ->orderBy('created_at', 'desc')
                ->first();

            //buscar todos os atendimentos para esse cliente na ultima data
            $services = Task::select()
                ->where('clientId', '=', $clientId->clientId)
                ->where('created_at', '=', $lastDate->created_at)
                ->get();

            $listaStatus = []; // Inicialize o array antes do loop foreach

            foreach ($services as $service) {
                $statusAtendimentos = Questionarie::where('taskId', $service->auvoId)
                    ->where(function ($query) {
                        $query->where('questionDescription', 'STATUS GERAL DO GRUPO GERADOR')
                            ->orWhere('questionDescription', 'Status geral do gerador')
                            ->orWhere('questionDescription', 'Status geral do grupo gerador e QTA');
                    })
                    ->get() // Use get() para obter todas as colunas
                    ->map(function ($item) {
                        return mb_strtolower($item->reply, 'UTF-8'); // Acesse a coluna 'reply' de cada item e aplique mb_strtolower()
                    })
                    ->toArray(); // Converta a coleção para um array simples

                // Adicione o array de status ao array $listaStatus
                $listaStatus = array_merge($listaStatus, $statusAtendimentos);
            }

            // Verifique os status obtidos
            if (in_array("inoperante", $listaStatus)) {
                $service->statusFarol = 'inoperante';
            } elseif (in_array("operando com restrição", $listaStatus)) {
                $service->statusFarol = 'operando com restrição';
            } else {
                $service->statusFarol = 'operando normalmente';
            }

            //busca os dados do cliente
            $dadosCliente = Client::select('razaoSocial', 'nome')
                ->where('idAuvo', '=', $clientId->clientId)
                ->first();

            if ($dadosCliente) {
                $service->razaoSocial = $dadosCliente->razaoSocial;
                $service->nome = $dadosCliente->nome;
            } else {
                $service->razaoSocial = "Sem cliente cadastrado";
                $service->nome = "Sem cliente cadastrado";
            }

            $tasks[] = $service; // Adiciona o resultado ao array $tasks


        }



        return view(
            'Exports.farol',
            [
                'tasks' => $tasks,
            ]
        );
    }
}
