@extends('layouts.app')

@section('content')

    @include('includes.errors')

    <div class="card">
        <div class="card-header">
            Edit poll: {{ $poll->title }}
        </div>
        <div class="card-body">
            <form action="{{ route('poll.update', ['slug' => $poll->slug]) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $poll->title }}">
                </div>
                <div class="row">
                    @foreach ($poll->poll_attachments as $poll_attachment)
                            <div class="col-md-6 center-block text-center form-group">
                                <img src="{{ asset($poll_attachment->attachment) }}" alt="" width="90px" height="90px">
                                <input type="file" name="attachment[{{$poll_attachment->id}}]" class="form-control mt-2">
                                <label for="description">Description</label>
                                <input type="text" name="description[{{$poll_attachment->id}}]" class="form-control" value="{{ $poll_attachment->description }}">
                            </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="category">Select a Category</label>
                    <select name="category_id" id="category" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                            @if ($poll->category->id == $category->id)
                                selected
                            @endif
                            >{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="deadline">Set deadline</label>
                    <p>Current deadline: {{ $poll->deadline }}</p>
                    <input type="date" name="deadline[]" id="deadline" class="form-control">
                    <br>
                    <input type="time" name="deadline[]" id="deadline" class="form-control">
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Update poll</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
