<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultations extends Model
{
    use HasFactory;

    public $incrementing = false;

    
    protected $fillable = [
            'id' ,
            'registry_id',
            'queries',
            'description'
    ];
}
