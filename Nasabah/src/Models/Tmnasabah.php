<?php

namespace Bryanjack\Nasabah\Models;

use Illuminate\Database\Eloquent\Model;

class Tmnasabah extends Model
{
    protected $fillable = [
        'name', 'duration', 'status'
    ];
}
