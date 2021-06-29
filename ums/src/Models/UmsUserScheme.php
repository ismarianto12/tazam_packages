<?php

namespace Bryanjack\Ums\Models;

use Illuminate\Database\Eloquent\Model;

class UmsUserScheme extends Model
{
    protected $connection = "db_ums";
    protected $table = "users_additionals_schema";
    
    protected $fillable = [
        'name', 'duration', 'status'
    ];
}
