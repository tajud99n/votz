@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            Published polls
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <th>Participated Date</th>
                    <th>Poll</th>
                    <th>Author</th>
                    <th>Voted choice</th>
                    <th>Poll results</th>
                </thead>
                <tbody>
                    @if ($polls->count() > 0)
                        @foreach ($polls as $poll)
                            <tr>
                                <td>{{ date("F jS, Y", strtotime($poll->created_at)) }}</td>                              
                                <td>{{ $poll->poll->title }}</td>
                                <td>{{ $poll->poll->user->name }}</td>
                                <td>
                                   <img src="{{ asset($poll->poll_attachment->attachment) }}" alt="" width="70px" height="70px">
                                </td>
                                @if ($poll->poll->result_status == 'published')
                                <td><a href="{{ route('poll.report', ['poll' => base64_encode($poll->poll_id.'*'.$poll->created_at)]) }}" class="btn btn-success">Result</a></td>
                                
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="5" class="text-center">No participated polls</th>
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
