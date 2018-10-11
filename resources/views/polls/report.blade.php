@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
               Poll: {{ $poll->title }}
        </div>
        <div class="card-body ">
          <div class="row">
                <div class="col-12">
                    <p>Category: {{ $poll->category->category }}</p>
                    <p>Date Created: {{ date("F jS, Y", strtotime($poll->created_at)) }}</p>
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