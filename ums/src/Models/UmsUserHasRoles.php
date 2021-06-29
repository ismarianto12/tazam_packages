<?php

namespace Bryanjack\Ums\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\UmsUser as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class UmsUserHasRoles extends Model
{
    use Notifiable;
    use HasRoles;

    protected $connection = "db_ums";
    protected $table = "user_has_roles";
    
    protected $fillable = [
        'role_id', 'user_id', 'app_id', 'created_user', 'updated_user'
    ];

    protected $attributes = [
        "status" => "1"
    ];
}
