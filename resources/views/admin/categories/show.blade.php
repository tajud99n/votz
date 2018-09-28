@extends('layouts.app')

@section('content')

   @include('includes.errors')

    <div class="card">
        <div class="card-header text-center text-capitalize">
            Category: <strong> {{ $category->category }} </strong>
        </div>
        <div class="card-body">
               <p><strong>Total polls:</strong> {{ $category->polls->count() }}</p>
               <p><strong>On going polls:</strong> {{ $in_progress->count() }}</p>
               <p><strong>Concluded polls:</strong> {{ $concluded->count() }}</p>
               <p><strong>Suspended polls:</strong> {{ $suspended->count() }}</p>
        </div>
    </div>
@endsection
