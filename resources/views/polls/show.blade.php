@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
               Poll: {{ $poll->title }}
                @if ($poll->result_status == 'not-published')
                    @if($poll->voting_status == 'concluded')
                        <span class="float-right"><a href="{{ route('poll.publish', ['publish' => base64_encode('published'.'*'.$poll->slug)]) }}" class="btn btn-xs btn-success">Publish results</a></span>
                    @else 
                        @if ($poll->voting_status == 'in-progress')
                            <span class="float-right"><a href="{{ route('poll.status', ['status' => base64_encode('suspended'.'*'.$poll->slug)]) }}" class="btn btn-xs btn-warning">Suspend Poll</a></span>
                        @else 
                            <span class="float-right"><a href="{{ route('poll.status', ['status' => base64_encode('in-progress'.'*'.$poll->slug)]) }}" class="btn btn-xs btn-success">Reinstate Poll</a></span>
                        @endif
                    @endif
                @endif
        </div>
        <div class="card-body ">
          <div class="row">
                <div class="col-12">
                    <p>Category: {{ $poll->category->category }}</p>
                    <p>Date Created: {{ date("F jS, Y", strtotime($poll->created_at)) }}</p>
                    <p>Stop Date: {{ $poll->deadline }}</p>
                    <p>Status: {{ $poll->voting_status }}</p>
                    <p>Result: {{ $poll->result_status }}</p>
                    <p>Total Votes: {{ $poll->votes->count() }}</p>
                </div>
                <hr>
                @foreach ($poll->poll_attachments as $poll_attachment)
                        <div class="col-md-6 center-block text-center">
                            <img src="{{ asset($poll_attachment->attachment) }}" alt="" width="90px" height="90px">
                            <p>{{ $poll_attachment->description }}</p>
                            <p>Number of votes: {{ $poll_attachment->votes->count() }}</p>
                        </div>
                @endforeach
          </div>
        </div>
    </div>
@endsection