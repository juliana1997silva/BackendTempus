<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;

    public $incrementing = false;

    
    protected $fillable = [
            'id' ,
            'name',
            'status'
    ];

    public function group()
    {
        return $this->hasOne(GroupPermissionsProxy::modelClass(), 'group_id');
    }
}
