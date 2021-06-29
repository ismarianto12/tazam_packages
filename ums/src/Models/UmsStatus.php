<?php

namespace Bryanjack\Ums\Models;

use Illuminate\Database\Eloquent\Model;

class UmsStatus extends Model
{
    protected $connection = "db_ums";
    protected $table = "user_status_parameters";
    
    protected $fillable = [
        'name', 'duration', 'status'
    ];
}
