<?php

namespace Bryanjack\Ums\Models;

use Illuminate\Database\Eloquent\Model;

class UmsPermission extends Model
{
    protected $connection = "db_ums";
    protected $table = "permissions";
    
    protected $fillable = [
        'name', 'guard_name', 'status', 'app_id', 'permission_id', 'created_user', 'updated_user'
    ];
}
