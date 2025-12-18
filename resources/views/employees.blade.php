{{-- ============================================== --}}
{{-- File: resources/views/employees.blade.php --}}
{{-- Purpose: Employee management (REAL DATA) --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Employees Directory</h2>

        <a href="{{ route('employees.create') }}"
           class="btn btn-primary shadow-sm px-4">
            <i class="bi bi-person-plus-fill me-2"></i> Add Employee
        </a>
    </div>

    {{-- Grid --}}
    <div class="row g-4">

        @forelse($employees as $employee)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card employee-card shadow-sm border-0 h-100">
                <div class="card-body text-center p-4 d-flex flex-column">

                    {{-- Avatar --}}
                    <div class="avatar-wrapper mx-auto mb-3">
                        @if($employee->avatar)
                            <img src="{{ asset('storage/' . $employee->avatar) }}"
                                 class="avatar-img">
                        @else
                            <div class="avatar-fallback">
                                {{ strtoupper(substr($employee->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Name --}}
                    <h5 class="fw-bold mb-1">{{ $employee->name }}</h5>
                    <p class="text-muted mb-2 text-capitalize">{{ $employee->role }}</p>

                    {{-- Email --}}
                    <div class="small text-secondary mb-1">
                        <i class="bi bi-envelope me-1"></i>
                        {{ $employee->email }}
                    </div>

                    {{-- Phone --}}
                    <div class="small text-secondary mb-1">
                        <i class="bi bi-telephone me-1"></i>
                        {{ $employee->phone ?? '—' }}
                    </div>

                    {{-- Address --}}
                    <div class="small text-secondary mb-3">
                        <i class="bi bi-geo-alt me-1"></i>
                        {{ $employee->address ?? '—' }}
                    </div>

                    {{-- Actions --}}
                    <div class="mt-auto d-flex justify-content-center gap-2">

                        <a href="{{ route('employees.edit', $employee->id) }}"
                           class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>

                        <form method="POST"
                              action="{{ route('employees.destroy', $employee->id) }}"
                              onsubmit="return confirm('Deactivate this employee?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                No employees found.
            </div>
        @endforelse

    </div>
</div>

{{-- Trash --}}
<a href="{{ route('employees.trash') }}"
   class="btn btn-secondary shadow-lg d-flex align-items-center gap-2 floating-trash-btn">
    <i class="bi bi-trash fs-5"></i>
    <span>View Trash</span>
</a>

{{-- Styles --}}
<style>
.employee-card {
    border-radius: 16px;
    transition: 0.3s;
}
.employee-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.1);
}

.avatar-wrapper {
    width: 90px;
    height: 90px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-img,
.avatar-fallback {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border: 3px solid #dee2e6;
    object-fit: cover;
}

.avatar-fallback {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f3f5;
    font-size: 32px;
    font-weight: 600;
    color: #6c757d;
}

.floating-trash-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    border-radius: 50px;
    padding: 10px 18px;
    z-index: 1050;
}
</style>
@endsection
