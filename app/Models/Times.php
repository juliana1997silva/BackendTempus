<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Times extends Model
{
    use HasFactory;

    public $incrementing = false;

    
    protected $fillable = [
            'id' ,
            'date',
            'user_id',
            'entry_time',
            'lunch_entry_time',
            'lunch_out_time',
            'out_time',
            'entry_time_nocommercial',
            'lunch_entry_time_nocommercial',
            'lunch_out_time_nocommercial',
            'out_time_nocommercial',
            'observation'
    ];
}
