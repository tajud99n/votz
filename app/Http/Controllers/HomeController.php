<?php

namespace App\Http\Controllers;

use Auth;
use App\Poll;
use App\Vote;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $polls = Poll::where('user_id', Auth::id())->get()->count();
        $trashed = Poll::onlyTrashed()->where('user_id', Auth::id())->get()->count();
        $participated = Vote::where('user_id', Auth::id())->get()->count();
        return view('home', compact(['polls', 'trashed', 'participated']));
    }
}
