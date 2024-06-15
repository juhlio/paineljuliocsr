<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicereport extends Model
{
    use HasFactory;

    protected $fillable = [
        'idOs',
        'problemDescription',
        'tecAvaliation',
        'serviceExecuted',
        'equipStatus',
    ];
}
