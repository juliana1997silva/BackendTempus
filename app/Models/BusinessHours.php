<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessHours extends Model
{
    use HasFactory;

    public $incrementing = false;

    
    protected $fillable = [
            'id' ,
            'date',
        'location',
            'user_id',
            'entry_time',
            'lunch_entry_time',
            'lunch_out_time',
            'out_time',
            'observation'
    ];
}
