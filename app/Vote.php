<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['poll_id', 'user_id', 'created_at'];
    
    public function poll()
    {
        return $this->belongsTo('App\Poll');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
