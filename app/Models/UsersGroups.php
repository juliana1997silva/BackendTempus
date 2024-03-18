<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersGroups extends Model
{
    use HasFactory;

    public $incrementing = false;

    
    protected $fillable = [
            'id' ,
            'group_id',
            'user_id'
    ];
}
