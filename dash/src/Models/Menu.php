<?php

namespace Bryanjack\Dash\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'parent', 'link', 'icon'
    ];

    public function childs()
    {
        return $this->hasMany('Bryanjack\Dash\Models\Menu', 'parent', 'id');
    }
}
