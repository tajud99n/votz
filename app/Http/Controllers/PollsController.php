<?php

namespace App\Http\Controllers;

use Auth;
use App\Poll;
use App\Poll_attachment;
use Session;
use Illuminate\Http\Request;

class PollsController extends Controller
{
    public function index()
    {
         return view('polls.index', ['polls' => Poll::all()]);
    }

    public function create()
    {
         return view('polls.create');
    }

    public function store()
    {
         $this->validate(request(), [
               'title'    => 'required',
               'attachments'  => 'required|image|max:1999',
               'description'  => 'required',
               'deadline'     => 'required'
          ]);

          //process attachment

          Poll::create([
               'title'   => request()->title, 
               'slug'    => str_slug(time.requst()->title), 
               'result_status'     => 'not-published', 
               'voting_status'     => 'in-progress', 
               'deadline'     => request()->deadline
          ]);

          Session::flash('success', 'Poll created successfully');

          return redirect()->route('home');
    }

    public function show($slug)
    {
          $poll = Poll::where('slug', $slug)->first();

          return view('polls.edit', compact(['poll'])); 
    }

    public function edit($slug)
    {
         $poll = Poll::where('slug', $slug)->first();

         return view('polls.edit', compact(['poll']));
    }

    public function update()
    {
         $this->validate(request(), [
               'title' => 'required',
               'attachments' => 'required|image|max:1999',
               'deadline' => 'required'
         ]);

    }
}
