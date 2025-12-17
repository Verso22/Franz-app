{{-- ============================================== --}}
{{-- File: resources/views/employees.blade.php --}}
{{-- Purpose: Employee management (REAL DATA from users table, Soft Delete) --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="container-fluid py-4">

    {{-- 🧱 Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Employees Directory</h2>

        {{-- ➕ Add Employee --}}
        <a href="{{ route('employees.create') }}"
           class="btn btn-primary shadow-sm px-4">
            <i class="bi bi-person-plus-fill me-2"></i> Add Employee
        </a>
    </div>

    {{-- 👥 Employee Grid --}}
    <div class="row g-4">

        @forelse($employees as $employee)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card employee-card shadow-sm border-0">
                    <div class="card-body text-center p-4">

                        {{-- Avatar --}}
                        @if($employee->avatar)
                            <img src="{{ asset('storage/' . $employee->avatar) }}"
                                 alt="Avatar"
                                 class="employee-avatar rounded-circle mb-3">
                        @else
                            <div class="employee-avatar mb-3
                                        d-flex align-items-center justify-content-center
                                        bg-light text-secondary fw-bold fs-4 rounded-circle">
                                {{ strtoupper(substr($employee->name, 0, 1)) }}
                            </div>
                        @endif

                        <h5 class="fw-bold mb-1">{{ $employee->name }}</h5>

                        <p class="text-muted mb-2 text-capitalize">
                            {{ $employee->role }}
                        </p>

                        <div class="small text-secondary mb-2">
                            <i class="bi bi-envelope me-1"></i>
                            {{ $employee->email }}
                        </div>

                        {{-- ⚙️ Admin Actions --}}
                        <div class="d-flex justify-content-center gap-2 mt-3">

                            {{-- Edit (future) --}}
                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                <i class="bi bi-pencil"></i> Edit
                            </button>

                            {{-- Soft Delete --}}
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

{{-- 🧭 Floating Trash Button --}}
<a href="{{ route('employees.trash') }}"
   class="btn btn-secondary shadow-lg d-flex align-items-center gap-2 floating-trash-btn">
    <i class="bi bi-trash fs-5"></i>
    <span>View Trash</span>
</a>

{{-- 💅 Styles --}}
<style>
.employee-card {
    border-radius: 16px;
    transition: all 0.3s ease;
}
.employee-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.1);
}

.employee-avatar {
    width: 90px;
    height: 90px;
    border: 3px solid #dee2e6;
    object-fit: cover;
}

.floating-trash-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    border-radius: 50px;
    padding: 10px 18px;
    font-weight: 500;
    z-index: 1050;
}
</style>
@endsection
    