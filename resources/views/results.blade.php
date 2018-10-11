@extends('layouts.app')

@section('content')

<div class="card">
     <div class="card-header">
          <h1>Search results: {{ $query }}</h1>
     </div>

     <div class="card-body">
     @if ($polls->count() > 0)
          <div class="case-item-wrap">
               @foreach ($polls as $poll)
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                         <div class="case-item">
                         <h6 class="case-item__title">Poll - <a href="{{ route('poll.participate', ['slug' => $poll->slug]) }}">{{ $poll->title }}</a></h6>
                         </div>
                    </div>
               @endforeach
          </div>
     @else
          <h1 class="text-center"> No result found</h1>
     @endif
     @if ($polls->count())
          <div class="pagination justify-content-center">
          {{ $polls->links() }}
          </div>
     @endif
     </div>
</div>

@endsection