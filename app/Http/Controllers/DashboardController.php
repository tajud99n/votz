<?php

namespace App\Http\Controllers;

use Auth;
use App\Poll;
use App\Vote;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function my_polls()
    {
        $polls = Poll::where('user_id', Auth::id())->paginate(5);

        return view('polls.mypolls', compact(['polls']));
    }

    public function participated()
    {
        $polls = Vote::where('user_id', Auth::id())->paginate(5);

        return view('polls.participated', compact(['polls']));
    }

    public function latest()
    {
        $polls = Poll::orderBy('created_at', 'desc')->where('voting_status', 'in-progress')->paginate(5);

        return view('polls.latest', compact(['polls']));
    }

    public function participate($slug)
    {
        $poll = Poll::where('slug', $slug)->first();

        return view('polls.vote', compact(['poll']));
    }



    public function report($poll)
    {
        $split = explode('*', base64_decode($poll));
        
        $poll = Poll::where('id', $split[0])->first();

        return view('polls.report', compact(['poll']));
    }

}
