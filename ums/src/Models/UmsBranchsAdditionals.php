<?php

namespace Bryanjack\Ums\Models;

use Illuminate\Database\Eloquent\Model;

class UmsBranchsAdditionals extends Model
{
    protected $connection = "db_ums";
    protected $table = "branchs_additionals";
    
    protected $fillable = [
        'name', 'duration', 'status'
    ];
}
