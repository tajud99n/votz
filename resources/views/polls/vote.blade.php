@extends('layouts.app')

@section('content')

    @include('includes.errors')

    <div class="card">
        <div class="card-header">
               Poll: {{ $poll->title }}
        </div>
        <div class="card-body ">
          <div class="row">
                <div class="col-12">
                    <p>Category: {{ $poll->category->category }}</p>
                    <p>Date Created: {{ date("F jS, Y", strtotime($poll->created_at)) }}</p>
                    <p>Stop Date: {{ $poll->deadline }}</p>
                </div>
                <hr>
                @foreach ($poll->poll_attachments as $poll_attachment)
                        <div class="col-md-6 center-block text-center">
                            <img src="{{ asset($poll_attachment->attachment) }}" alt="" width="90px" height="90px">
                            <p>{{ $poll_attachment->description }}</p>
                            @if ($poll->id != Auth::id())
                            @if (!$poll->already_voted_by_auth_user())
                            <a href="{{ route('poll.vote', ['vote' => base64_encode($poll->id.':*/*:'.$poll_attachment->id)]) }}" class="btn btn-success btn-xs">Vote</a>
                            @endif
                            @endif
                        </div>
                @endforeach
          </div>
        </div>
    </div>
@endsection