@extends('layouts.app')

@section('content')

   @include('includes.errors')

    <div class="card">
        <div class="card-header text-center">
            <strong>Update category:</strong> {{ $category->category }}
        </div>
        <div class="card-body">
            <form action="{{ route('category.update', ['id' => $category->id]) }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="category">Name</label>
                    <input type="text" name="category" value="{{ $category->category }}" class="form-control">
                </div>

                <div class="form-group">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Update Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
