<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinators extends Model
{
    use HasFactory;

    public $incrementing = false;


    protected $fillable = [
        'id',
        'name',
        'group_id',
        'status'
    ];
}
