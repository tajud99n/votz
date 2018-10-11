<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Vote;

use Illuminate\Http\Request;

class VotesController extends Controller
{
    public function vote($vote)
    {
        $split = explode(':*/*:', base64_decode($vote));

        $vote = new Vote;

        $vote->poll_id = $split[0];
        $vote->poll_attachment_id = $split[1];
        $vote->user_id = Auth::id();
        $vote->created_at = date('Y-m-d H:i:s');

        $vote->save();

        Session::flash('success', 'You have successfully voted in the poll');

        return redirect()->route('poll.participated');
    }
}
