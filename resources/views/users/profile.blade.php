@extends('layouts.app')

@section('content')

    @include('includes.errors')

    <div class="card">
        <div class="card-header">
            Edit your profile
        </div>
        <div class="card-body">
            <form action="{{ route('user.profile.update') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                </div>
                @if ($user->profile)
                    <div class="form-group">
                        <label for="description">About you</label>
                        <textarea name="description" id="description"  cols="6" rows="10" class="form-control">{{ $user->profile->description }}</textarea>
                    </div>
                @else
                    <div class="form-group">
                        <label for="description">About you</label>
                        <textarea name="description" id="description"  cols="6" rows="10" class="form-control"></textarea>
                    </div>
                @endif
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                </div>
                @if (!$user->provider)
                    <div class="form-group">
                        <label for="password">Current Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" name="new_password" class="form-control">
                    </div>
                @endif
                <div class="form-group">
                    <label for="avatar">Upload new avatar</label>
                    <input type="file" name="avatar" class="form-control">
                </div>

                <div class="form-group">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Update profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
