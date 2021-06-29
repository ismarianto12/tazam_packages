<?php

namespace Bryanjack\Ums\Models;

use Illuminate\Database\Eloquent\Model;

class UmsRole extends Model
{
    protected $connection = "db_ums";
    protected $table = "roles";
    
    protected $fillable = [
        'name', 'duration', 'status', 'guard_name', 'role_id', 'status', 'app_id', 'hierarcy_id', 'created_user', 'updated_user'
    ];
}
