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
                    <th>View</th>
                    <th>Trash</th>
                    <th>Permanent Delete</th>
                </thead>
                <tbody>
                    @if ($polls->count() > 0)
                        @foreach ($polls as $poll)
                            <tr>
                                <td>{{ $poll->title }}</td>
                                <td>{{ $poll->user->name }}</td>
                                <td><a href="{{ route('poll.show', ['slug' => $poll->slug]) }}" class="btn btn-info">View</a></td>
                                <td><a href="{{ route('poll.delete', ['slug' => $poll->slug]) }}" class="btn btn-warning">Trash</a></td>
                                @if ($poll->votes->count() == 0)
                                <td><a href="{{ route('poll.kill', ['id' => $poll->id]) }}" class="btn btn-danger">Delete</a></td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="5" class="text-center">No published polls</th>
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
