<?php

namespace Bryanjack\Aplikasi\Models;

use Illuminate\Database\Eloquent\Model;

class Aplikasi extends Model
{
    protected $fillable = [
        'name', 'duration', 'status'
    ];
}
