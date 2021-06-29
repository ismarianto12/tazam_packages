<?php

namespace Bryanjack\Ums\Models;

use Illuminate\Database\Eloquent\Model;

class UmsUserAdditionals extends Model
{
    protected $connection = "db_ums";
    protected $table = "users_additionals";
    
    protected $fillable = [
        'name', 'duration', 'status'
    ];
}
