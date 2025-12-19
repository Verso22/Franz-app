@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container-fluid py-4" style="max-width:900px;">

    <h2 class="fw-bold mb-4">Profile</h2>

    @include('profile.customer', ['user' => $user])

</div>
@endsection
