<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['title', 'slug', 'result_status', 'voting_status', 'deadline', 'category_id', 'user_id'];

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

    public function poll_attachments()
    {
        return $this->hasMany('App\Poll_attachment');
    }

    public function already_voted_by_auth_user()
    {
        $id = Auth::id();

        $votes = [];

        foreach ($this->votes as $vote) {
            array_push($votes, $vote->user_id);
        }

        return (in_array($id, $votes)) ? true : false;
    }
}
