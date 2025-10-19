@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height:80vh;">
    <div class="card shadow-sm p-4" style="width: 400px;">
        <h3 class="text-center fw-bold mb-4">Login</h3>
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <small>Don't have an account? <a href="{{ route('register') }}">Register</a></small>
        </div>
    </div>
</div>
@endsection
