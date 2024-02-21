<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    public $incrementing = false;

    
    protected $fillable = [
            'id' ,
            'registry_id',
            'km',
            'coffe',
            'lunch',
            'dinner',
            'parking',
            'toll',
            'others',
            'total'
    ];
}
