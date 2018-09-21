<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category', 'slug'];

    public function polls()
    {
        return $this->hasMany('App\Poll');
    }
}
