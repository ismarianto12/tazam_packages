<?php

namespace Bryanjack\Ums\Models;

use Illuminate\Database\Eloquent\Model;

class UmsRoleHasPermissions extends Model
{
    protected $connection = "db_ums";
    protected $table = "role_has_permissions";
    
    protected $fillable = [
        'permission_id', 'user_id', 'app_id', 'created_user', 'updated_user', 'role_id'
    ];
}
