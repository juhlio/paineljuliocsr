<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productscategorie extends Model
{
    protected $fillable = [
        'id',
        'descricao',
        'idAuvo'
    ];
    use HasFactory;
}
