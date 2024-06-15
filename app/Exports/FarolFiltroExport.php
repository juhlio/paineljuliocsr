<?php

namespace App\Exports;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FarolFiltroExport implements FromView
{
    protected $tasks;

    public function __construct($tasks)
    {
        $this->tasks = $tasks;
    }

    public function view(): View
    {
        return view('Exports.farol', [
            'tasks' => $this->tasks,
        ]);
    }
}

