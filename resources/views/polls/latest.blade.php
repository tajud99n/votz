@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            Published polls
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <th>Poll</th>
                    <th>Created by</th>
                    <th>Participate</th>
                </thead>
                <tbody>
                
                    @if ($polls->count() > 0)
                        @foreach ($polls as $poll)
                            <tr>
                                <td>{{ $poll->title }}</td>
                                @if ($poll->user_id != Auth::id())
                                    <td>{{ $poll->user->name }}</td>
                                @else 
                                    <td>You</td>
                                @endif
                                @if ($poll->user_id != Auth::id())
                                    @if (!$poll->already_voted_by_auth_user())
                                        <td><a href="{{ route('poll.participate', ['slug' => $poll->slug]) }}" class="btn btn-info">Participate</a></td>
                                    @else
                                        <td><strike>Participated</strike></td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="5" class="text-center">No polls available</th>
                        </tr>
                    @endif
                </tbody>
            </table>
            @if ($polls->count())
                <div class="pagination justify-content-center">
                    {{ $polls->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection
