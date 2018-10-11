@extends('layouts.app')

@section('content')

    @include('includes.errors')

    <div class="card">
        <div class="card-header">
            Create a new Poll
        </div>
        <div class="card-body">
            <form action="{{ route('poll.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="featured">Featured Image I</label>
                    <input type="file" name="attachment[]" class="form-control">
                    <label for="description">Description</label>
                    <input type="text" name="description[]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="featured">Featured Image II</label>
                    <input type="file" name="attachment[]" class="form-control">
                    <label for="description">Description</label>
                    <input type="text" name="description[]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="category">Select a Category</label>
                    <select name="category_id" id="category" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="deadline">Set deadline</label>
                    <input type="date" name="deadline[]" id="deadline" class="form-control">
                    <br>
                    <input type="time" name="deadline[]" id="deadline" class="form-control">
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Create Poll</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection