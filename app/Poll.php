<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = ['title', 'slug', 'result_status', 'voting_status', 'deadline', 'category_id'];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function poll_attachment()
    {
        return $this->hasMany('App\Poll_attachment');
    }
}
