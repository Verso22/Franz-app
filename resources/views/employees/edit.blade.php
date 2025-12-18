@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
<div class="container-fluid py-4">

    <h2 class="fw-bold mb-4">Edit Employee</h2>

    <form method="POST"
          action="{{ route('employees.update', $employee->id) }}"
          enctype="multipart/form-data"
          class="card shadow-sm border-0 p-4">

        @csrf
        @method('PUT')

        <div class="row g-3">

            {{-- Name --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $employee->name) }}"
                       required>
            </div>

            {{-- Email --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email', $employee->email) }}"
                       required>
            </div>

            {{-- Phone --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Phone Number</label>
                <input type="text"
                       name="phone"
                       class="form-control"
                       value="{{ old('phone', $employee->phone) }}">
            </div>

            {{-- Address --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Address</label>
                <textarea name="address"
                          class="form-control"
                          rows="3">{{ old('address', $employee->address) }}</textarea>
            </div>

            {{-- Current Avatar --}}
            <div class="col-12">
                <label class="form-label fw-semibold d-block">Current Profile Image</label>

                @if($employee->avatar)
                    <img src="{{ asset('storage/' . $employee->avatar) }}"
                         alt="Avatar"
                         class="rounded-circle mb-3"
                         style="width: 90px; height: 90px; object-fit: cover;">
                @else
                    <div class="rounded-circle mb-3
                                d-flex align-items-center justify-content-center
                                bg-light text-secondary fw-bold fs-4"
                         style="width: 90px; height: 90px;">
                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            {{-- New Avatar --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Change Profile Image</label>
                <input type="file"
                       name="avatar"
                       class="form-control"
                       accept="image/*">
            </div>

        </div>

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">
                Update Employee
            </button>

            <a href="{{ route('employees.index') }}"
               class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>

    </form>
</div>
@endsection
