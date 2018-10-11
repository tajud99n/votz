<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use File;
use App\Category;
use App\Poll;
use App\Poll_attachment;
use App\Vote;
use Session;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Http\Request;

class PollsController extends Controller
{
      public function index()
      {
            return view('polls.index', ['polls' => Poll::orderBy('created_at', 'desc')->paginate(3)]);
      }

      public function create()
      {
            return view('polls.create', ['categories' => Category::all()]);
      }

      public function store(Request $request)
      {
            $this->validate($request, [
                  'title'    => 'required',
                  'attachment'  => 'required|array|min:2',
                  'attachment.*'  => 'required|image|max:1999',
                  'description'  => 'required|array|min:2',
                  'description.*'  => 'required|string|distinct|min:3',
                  'deadline'     => 'required|array|min:2',
                  'deadline.*'      => 'required',
                  'category_id'     => 'required'
            ]);

            $deadline = implode(" ", $request->deadline) . ":00";
            
            $poll = Poll::create([
                  'title'   => $request->title, 
                  'slug'    => str_slug(time() . $request->title), 
                  'result_status'     => 'not-published', 
                  'voting_status'     => 'in-progress', 
                  'deadline'     => $deadline,
                  'category_id'     => $request->category_id,
                  'user_id'   => Auth::id()
            ]);
            
            //process attachment
            $count = count($request->attachment);
            $attachment = $request->file('attachment');
            $description = $request->description;

            for ($i=0; $i < $count ; $i++) {
                  $attachment_new_name = $attachment[$i];

                  Cloudder::upload($attachment_new_name);

                  $c = Cloudder::getResult();

                  Poll_attachment::create([
                        'poll_id' => $poll->id,
                        'attachment' => $c['url'],
                        'attachment_publicID' => $c['public_id'],
                        'description' => $description[$i]
                  ]);
            }

            Session::flash('success', 'Poll created successfully');

            return redirect()->route('poll.mypolls');
      }

      public function show($slug)
      {
            $poll = Poll::where('slug', $slug)->first();

            return view('polls.show', compact(['poll'])); 
      }

      public function edit($slug)
      {
            $poll = Poll::where('slug', $slug)->first();
            $categories = Category::all();

            return view('polls.edit', compact(['poll', 'categories']));
      }

      public function update(Request $request, $slug)
      {
            $poll = Poll::where('slug', $slug)->first();
            
            $this->validate($request, [
                  'title' => 'required',
                  'category_id'     => 'required',
                  'description' => 'required|array|min:2',
                  'description.*' => 'required|string|distinct|min:3',
            ]);

            $description = $request->description;

            foreach ($description as $key => $value) {
                  DB::table('poll_attachments')
                        ->where('id', $key)
                        ->update([
                              'description' => $description[$key]
                        ]);
            }

            $deadline_array = $request->deadline;
            $deadline = array_filter($deadline_array, function($x) {return !empty($x); });

            if (count($deadline) > 0) {

                  $this->validate($request, [
                        'deadline' => 'array|min:2',
                        'deadline.*' => 'min:5'
                  ]);

                  $deadline = implode(" ", $request->deadline) . ":00";
                  $poll->deadline = $deadline;
            }

            if ($request->hasFile('attachment')) {
                  $this->validate($request, [
                        'attachment' => 'required|array|min:1',
                        'attachment.*' => 'required|image|max:1999'
                  ]);

                  $attachment = $request->file('attachment');

                  foreach ($attachment as $key => $value) {
                        $old_attachment = Poll_attachment::find($key);

                        $attachment_new_name = $attachment[$key];

                        Cloudder::upload($attachment_new_name);
                        $c = Cloudder::getResult();

                        DB::table('poll_attachments')
                        ->where('id', $key)
                        ->update([
                              'attachment' => $c['url'],
                              'attachment_publicID' => $c['public_id']
                        ]);
                        
                        Cloudder::destroyImage($old_attachment->attachment_publicID);
                        Cloudder::delete($old_attachment->attachment_publicID);
                  }

            }

            if ($poll->title != $request->title) {
                  $poll->title = $request->title;
                  $poll->slug = str_slug(time() . $poll->title);
            }
            
            if ($poll->category_id != $request->category_id) {
                  $poll->category_id = $request->category_id;
            }

            $poll->save();

            Session::flash('success', 'Poll updated successfully');

            return redirect()->route('polls');

      }

      public function destroy($slug)
      {
            $poll = Poll::where('slug', $slug)->first();

            $poll->delete();

            Session::flash('success', 'Poll successfully trashed.');

            return redirect()->back();
      }

      public function kill($id)
      {
            $poll = Poll::find($id);

            $attachments = $poll->poll_attachments;

            foreach ($attachments as $attachment) {

                  Cloudder::destroyImage($attachment->attachment_publicID);
                  Cloudder::delete($attachment->attachment_publicID);

                  $attachment->delete();
            }

            $poll->forceDelete();

            Session::flash('success', 'Poll successfully deleted.');

            return redirect()->back();
      }

      public function trashed()
      {
            $polls = Poll::onlyTrashed()->get() ;

            return view('polls.trashed')->with('polls', $polls);
      }

      public function restore($id)
      {
            $poll = Poll::withTrashed()->where('id', $id)->first();

            $poll->restore();

            Session::flash('success', 'Poll restored successfully.');

            return redirect()->route('polls');
      }

      public function status($status)
      {
            $split = explode('*', base64_decode($status));

            $poll = Poll::where('slug', $split[1])->first();

            $poll->voting_status = $split[0];

            $poll->save();

            Session::flash('success', 'Poll status successfully changed');

            return redirect()->back();
      }

      public function publish($publish)
      {
            $split = explode('*', base64_decode($publish));

            $poll = Poll::where('slug', $split[1])->first();

            $poll->result_status = $split[0];

            $poll->save();

            Session::flash('success', 'Poll status successfully changed');

            return redirect()->back();
      }

}
