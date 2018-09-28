@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header text-center">
            <strong>CATEGORIES</strong>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <th>Name</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </thead>
                <tbody>
                    @if ($categories->count() > 0)
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    {{ $category->category }}
                                </td>
                                <td>
                                    <a href="{{ route('category.show', ['id' => $category->id]) }}" class="btn btn-xs btn-secondary">
                                        Stats
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('category.edit', ['id' => $category->id]) }}" class="btn btn-xs btn-info">
                                        Edit
                                    </a>
                                </td>
                                <td>
                                    @if ($category->polls()->count() < 1)
                                        <a href="{{ route('category.delete', ['id' => $category->id]) }}" class="btn btn-xs btn-danger">
                                            Delete
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="5" class="text-center">No categories</th>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="pagination justify-content-center">
                {{ $categories->links() }}
            </div>
        </div>
    </div>

@endsection
