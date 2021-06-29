<?php

namespace Bryanjack\Ums\Models;

use Illuminate\Database\Eloquent\Model;

class UmsUserHasPermissions extends Model
{
    protected $connection = "db_ums";
    protected $table = "user_has_permissions";
    
    protected $fillable = [
        'name', 'duration', 'status'
    ];
}
