<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'auvoId',
        'clientId',
        'equipId',
        'typeId',
        'type',
        'obs',
        'osurl',
        'taskDate',
        'taskStatus',
    ];
}
