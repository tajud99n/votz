@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            Trashed polls
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <th>Title</th>
                    <th>Restore</th>
                    <th>Destroy</th>
                </thead>
                <tbody>
                    @if ($polls->count() > 0)
                        @foreach ($polls as $poll)
                            <tr>
                                <td>{{ $poll->title }}</td>
                                <td><a href="{{ route('poll.restore', ['id' => $poll->id]) }}" class="btn btn-xs btn-success">Restore</a></td>
                                <td><a href="{{ route('poll.kill', ['id' => $poll->id]) }}" class="btn btn-xs btn-danger">Destroy</a></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="5" class="text-center">No trashed polls</th>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection
