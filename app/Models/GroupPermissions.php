<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupPermissions extends Model
{
    use HasFactory;

    public $incrementing = false;


    protected $fillable = [
        'id',
        'group_id',
        'permissions_id',
        'status'
    ];

    public function permissions()
    {
        return $this->hasOne(PermissionsProxy::modelClass(), 'id', 'permission_id');
    }

    public function groups()
    {
        return $this->hasOne(GroupProxy::modelClass(), 'id', 'group_id');
    }
}
