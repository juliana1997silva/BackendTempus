<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;

    public $incrementing = false;


    protected $fillable = [
        'id',
        'name',
        'image',
        'status',
        'description'
    ];

    public function permissions()
    {
        return $this->hasOne(GroupPermissionsProxy::modelClass(), 'permission_id');
    }
}
