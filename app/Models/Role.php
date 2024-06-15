<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
    use HasFactory;

    public function users()
{
    return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
}
}
