@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header text-center bg-info">
                    POLLS
                </div>
                <div class="card-body">
                    <h2 class="text-center">{{ $polls }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header text-center bg-success">
                    PARTICIPATED POLLS
                </div>
                <div class="card-body">
                    <h2 class="text-center">{{ $participated }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header text-center bg-danger">
                    TRASHED POLLS
                </div>
                <div class="card-body">
                    <h2 class="text-center">{{ $trashed }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
