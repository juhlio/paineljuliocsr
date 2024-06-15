<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obsreqcompra extends Model
{

    protected $fillable =[
        'idreqcompra',
        'obs',
    ];
    use HasFactory;
}
