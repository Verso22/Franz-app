@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')
<div class="container-fluid py-4">

    <h2 class="fw-bold mb-4">Add Employee</h2>

    <form method="POST"
          action="{{ route('employees.store') }}"
          enctype="multipart/form-data"
          class="card shadow-sm border-0 p-4">

        @csrf

        <div class="row g-3">

            {{-- Name --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required>
            </div>

            {{-- Email --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       required>
            </div>

            {{-- Phone --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Phone Number</label>
                <input type="text"
                       name="phone"
                       class="form-control">
            </div>

            {{-- Role --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Role</label>
                <select name="role" class="form-select" required>
                    <option value="employee">Employee</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            {{-- Address --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Address</label>
                <textarea name="address"
                          class="form-control"
                          rows="3"></textarea>
            </div>

            {{-- Avatar --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Profile Image</label>
                <input type="file"
                       name="avatar"
                       class="form-control"
                       accept="image/*">
            </div>

            {{-- Password --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       required>
            </div>

            {{-- Confirm Password --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Confirm Password</label>
                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       required>
            </div>

        </div>

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">
                Save Employee
            </button>
            <a href="{{ route('employees.index') }}"
               class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>

    </form>
</div>
@endsection
