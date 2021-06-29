<?php

namespace Bryanjack\Aplikasi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tmparameter extends Model
{
    use HasFactory;

    protected $table = 'tmparameter';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];
}
