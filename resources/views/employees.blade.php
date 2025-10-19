{{-- ============================================== --}}
{{-- File: resources/views/employees.blade.php --}}
{{-- Purpose: Modern employee directory grid with admin-only Add/Delete + Trash --}}
{{-- ============================================== --}}

@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="container-fluid py-4">

    {{-- 🧱 Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Employees Directory</h2>

        {{-- ➕ Add Employee (Admin only) --}}
        @if(auth()->check() && auth()->user()->isAdmin())
        <a href="#" class="btn btn-primary shadow-sm px-4">
            <i class="bi bi-person-plus-fill me-2"></i> Add Employee
        </a>
        @endif
    </div>

    {{-- 👥 Employee Grid --}}
    <div class="row g-4">
        @php
            // Mock employee data for preview
            $employees = [
                [
                    'name' => 'Sarah Johnson',
                    'role' => 'Store Manager',
                    'department' => 'Management',
                    'email' => 'sarah.johnson@example.com',
                    'phone' => '+62 812-3456-7890',
                    'image' => 'https://i.pravatar.cc/150?img=5',
                ],
                [
                    'name' => 'Michael Tan',
                    'role' => 'Cashier',
                    'department' => 'Front Desk',
                    'email' => 'michael.tan@example.com',
                    'phone' => '+62 813-4567-2345',
                    'image' => 'https://i.pravatar.cc/150?img=12',
                ],
                [
                    'name' => 'Alya Rahma',
                    'role' => 'Inventory Staff',
                    'department' => 'Warehouse',
                    'email' => 'alya.rahma@example.com',
                    'phone' => '+62 819-1234-5678',
                    'image' => 'https://i.pravatar.cc/150?img=47',
                ],
                [
                    'name' => 'Daniel Pratama',
                    'role' => 'Sales Representative',
                    'department' => 'Sales',
                    'email' => 'daniel.pratama@example.com',
                    'phone' => '+62 817-9876-5432',
                    'image' => 'https://i.pravatar.cc/150?img=18',
                ],
            ];
        @endphp

        @foreach($employees as $employee)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card employee-card shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <img src="{{ $employee['image'] }}" alt="Employee Photo" class="rounded-circle mb-3 employee-avatar">
                    <h5 class="fw-bold mb-1">{{ $employee['name'] }}</h5>
                    <p class="text-muted mb-2">{{ $employee['role'] }}</p>

                    <div class="small text-secondary mb-3">
                        <i class="bi bi-building me-1"></i>{{ $employee['department'] }}
                    </div>

                    <div class="small text-secondary mb-2">
                        <i class="bi bi-envelope me-1"></i>{{ $employee['email'] }}
                    </div>
                    <div class="small text-secondary mb-3">
                        <i class="bi bi-telephone me-1"></i>{{ $employee['phone'] }}
                    </div>

                    {{-- ⚙️ Admin-only Actions --}}
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- 🧭 Floating Trash Button (Admin only) --}}
@if(auth()->check() && auth()->user()->isAdmin())
<a href="#" class="btn btn-secondary shadow-lg d-flex align-items-center gap-2 floating-trash-btn">
    <i class="bi bi-trash fs-5"></i>
    <span>View Trash</span>
</a>
@endif

{{-- 💅 Page Styles --}}
<style>
.employee-card {
    border-radius: 16px;
    transition: all 0.3s ease;
    background-color: #fff;
}
.employee-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.1);
}
.employee-avatar {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border: 3px solid #dee2e6;
    transition: transform 0.3s ease;
}
.employee-card:hover .employee-avatar {
    transform: scale(1.05);
}

/* Floating Trash Button */
.floating-trash-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background-color: #6c757d;
    border: none;
    border-radius: 50px;
    padding: 10px 18px;
    font-weight: 500;
    color: #fff;
    transition: all 0.25s ease;
    z-index: 1050;
}
.floating-trash-btn:hover {
    background-color: #5a6268;
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(0,0,0,0.2);
    color: #fff;
    text-decoration: none;
}
</style>
@endsection
