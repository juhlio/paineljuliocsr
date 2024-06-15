<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{

    protected $fillable = [
        'clientId',
        'contactName',
        'position',
        'phone',
        'description',
    ];


    use HasFactory;
}
