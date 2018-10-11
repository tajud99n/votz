<?php

namespace App;

use Auth;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['poll_id', 'user_id', 'poll_attachment_id', 'created_at'];
    public $timestamps = false;

    
    public function poll()
    {
        return $this->belongsTo('App\Poll');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function poll_attachment()
    {
        return $this->belongsTo('App\Poll_attachment');
    }

}
