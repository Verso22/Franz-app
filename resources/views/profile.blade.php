{{-- ============================================== --}}
{{-- File: resources/views/profile.blade.php --}}
{{-- Purpose: Compact modern profile card with change password form --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg border-0 p-4" style="width: 420px; border-radius: 1rem;">
        <div class="text-center mb-4">
            <img src="https://cdn-icons-png.flaticon.com/512/219/219970.png" alt="Avatar" class="rounded-circle mb-3" width="90" height="90">
            <h4 class="fw-bold mb-0">{{ auth()->user()->name }}</h4>
            <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
        </div>

        <div class="mb-4 text-center">
            <p class="text-muted mb-1"><i class="bi bi-envelope"></i> {{ auth()->user()->email }}</p>
        </div>

        <hr>

        {{-- 🔐 Change Password Form --}}
        <h5 class="fw-semibold mb-3 text-center">Change Password</h5>
        <form action="{{ route('profile.updatePassword') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 shadow-sm">Update Password</button>
        </form>
    </div>
</div>

{{-- 💅 Optional Styles for smooth card --}}
<style>
.card {
    background: #fff;
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-3px);
}
</style>
@endsection
