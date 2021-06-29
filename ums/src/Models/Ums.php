<?php

namespace Bryanjack\Ums\Models;

use Illuminate\Database\Eloquent\Model;

class Ums extends Model
{
    protected $fillable = [
        'name', 'duration', 'status'
    ];
}
