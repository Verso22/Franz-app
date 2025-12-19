@extends('layouts.public')

@section('title', 'My Profile')

@section('content')
<div class="container py-5" style="max-width: 900px;">

    <h2 class="fw-bold mb-4">My Profile</h2>

    <div class="row g-4">

        {{-- PROFILE INFO --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0 p-4">

                <div class="text-center mb-3">
                    @if($user->avatar)
                        <img src="{{ asset('storage/'.$user->avatar) }}"
                             class="rounded-circle mb-2"
                             style="width:100px;height:100px;object-fit:cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center fs-3"
                             style="width:100px;height:100px;">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                    @endif

                    <h5 class="fw-semibold mt-2">{{ $user->name }}</h5>
                    <small class="text-muted">Customer</small>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input class="form-control" name="name" value="{{ $user->name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input class="form-control" name="phone" value="{{ $user->phone }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address">{{ $user->address }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Profile Photo</label>
                        <input type="file" name="avatar" class="form-control">
                    </div>

                    <button class="btn btn-primary w-100">Save Profile</button>
                </form>
            </div>
        </div>

        {{-- PASSWORD --}}
        <div class="col-md-7">
            <div class="card shadow-sm border-0 p-4">
                <h5 class="fw-semibold mb-3">Change Password</h5>

                <form method="POST" action="{{ route('profile.updatePassword') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control">
                    </div>

                    <button class="btn btn-outline-primary w-100">
                        Update Password
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
