<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionarie extends Model
{
    use HasFactory;

    protected $fillable = [
        'taskId',
        'equipId',
        'questionId',
        'questionDescription',
        'replyId',
        'reply',
        
    ];
}
