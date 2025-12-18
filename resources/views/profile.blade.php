{{-- ============================================== --}}
{{-- File: resources/views/profile.blade.php --}}
{{-- Purpose: Unified profile page (ALL ROLES) --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid py-4 d-flex justify-content-center">

    <div class="row w-100" style="max-width: 900px;">

        {{-- ================= PROFILE INFO ================= --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0 p-4 mb-4">

                <div class="text-center mb-4">

                    {{-- Avatar --}}
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}"
                             class="rounded-circle mb-3 d-block mx-auto"
                             style="width: 100px; height: 100px; object-fit: cover;">
                    @else
                        <div class="rounded-circle mb-3
                                    d-flex align-items-center justify-content-center
                                    bg-light text-secondary fw-bold fs-3 mx-auto"
                             style="width: 100px; height: 100px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    <h5 class="fw-bold mb-0">{{ $user->name }}</h5>
                    <small class="text-muted text-capitalize">{{ $user->role }}</small>
                </div>

                <hr>

                {{-- 👤 Update Profile --}}
                <h6 class="fw-semibold mb-3">Profile Information</h6>

                <form method="POST"
                      action="{{ route('profile.update') }}"
                      enctype="multipart/form-data">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $user->name) }}"
                               required>
                    </div>

                    {{-- Email (readonly) --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               class="form-control"
                               value="{{ $user->email }}"
                               readonly>
                    </div>

                    {{-- Phone --}}
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ old('phone', $user->phone) }}">
                    </div>

                    {{-- Address --}}
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address"
                                  class="form-control"
                                  rows="2">{{ old('address', $user->address) }}</textarea>
                    </div>

                    {{-- Avatar --}}
                    <div class="mb-3">
                        <label class="form-label">Profile Photo</label>
                        <input type="file"
                               name="avatar"
                               class="form-control"
                               accept="image/*">
                    </div>

                    <button class="btn btn-primary w-100">
                        Save Profile
                    </button>
                </form>
            </div>
        </div>

        {{-- ================= PASSWORD ================= --}}
        <div class="col-md-7">
            <div class="card shadow-sm border-0 p-4">

                <h6 class="fw-semibold mb-3">Change Password</h6>

                <form method="POST" action="{{ route('profile.updatePassword') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password"
                               name="current_password"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password"
                               name="new_password"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password"
                               name="new_password_confirmation"
                               class="form-control"
                               required>
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
