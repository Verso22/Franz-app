@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height:80vh;">
    <div class="card shadow-sm p-4" style="width: 400px;">
        <h3 class="text-center fw-bold mb-4">Create Account</h3>
        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Register</button>
        </form>
        <div class="text-center mt-3">
            <small>Already have an account? <a href="{{ route('login') }}">Login</a></small>
        </div>
    </div>
</div>
@endsection
