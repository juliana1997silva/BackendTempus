<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Contracts\UsersGroups as UsersGroupsContracts;

class UsersGroups extends Model implements UsersGroupsContracts
{
    use HasFactory;

    public $incrementing = false;

    
    protected $fillable = [
            'id' ,
            'group_id',
            'user_id'
    ];

    public function users()
    {
        return $this->hasOne(UsersProxy::modelClass(), 'id','user_id');
    }
}
