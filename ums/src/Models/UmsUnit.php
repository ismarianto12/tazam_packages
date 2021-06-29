<?php

namespace Bryanjack\Ums\Models;

use Illuminate\Database\Eloquent\Model;

class UmsUnit extends Model
{
    protected $connection = "db_ums";
    protected $table = "branchs";
    
    protected $fillable = [
        'name', 'duration', 'status'
    ];
}
