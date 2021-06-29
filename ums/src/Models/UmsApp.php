<?php

namespace Bryanjack\Ums\Models;

use Illuminate\Database\Eloquent\Model;

class UmsApp extends Model
{
    protected $connection = "db_ums";
    protected $table = "apps";
    
    protected $fillable = [
        'name', 'duration', 'status'
    ];
}
