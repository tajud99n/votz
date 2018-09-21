<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll_attachment extends Model
{
    protected $fillable = ['poll_id', 'attachment', 'description'];

    public function poll()
    {
        return $this->belongsTo('App\Poll');
    }
}
