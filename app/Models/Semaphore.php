<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semaphore extends Model
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
