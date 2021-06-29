<?php

namespace Bryanjack\Ums\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\UmsUser as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class UmsUser extends Model
{
    use Notifiable;
    use HasRoles;
    
    protected $connection = "db_ums";
    protected $table = "users";
    
    protected $fillable = [
        'name', 'email', 'password', 'status', 'unit', 'username', 'NIK', 'phone', 'created_user', 'jabatan'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $attributes = [
        'flag_update' => '2',
    ];

}
