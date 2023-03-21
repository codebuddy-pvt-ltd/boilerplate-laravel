@extends('layouts.admin-auth')

@section('title')
{{ config('app.name') }} | Login
@endsection

@section('card-title')
<h5 class="text-h5">Welcome to Admin</h5>
@endsection

@section('content')
<div class="p-2">
    <form class="form-horizontal ajax-form" action="{{ route('admin.login.store') }}" method="post">
        @csrf
        <div class="mb-4">
            <label for="email" class="form-label">Email <sup>*</sup></label>
            <input type="email" name="email" class="form-control" id="email"
                placeholder="Enter your email">
        </div>
        <div class="mb-4">
            <label class="form-label">Password <sup>*</sup></label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password">
        </div>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check ">
                <input class="form-check-input" type="checkbox" value="1" id="remember-check" name="remember">
                <label class="form-check-label" for="remember-check">
                    Keep me logged in
                </label>
            </div>
            <a href="{{ route('admin.forgot-password.index') }}" class="text-muted">Forgot Password?</a>
        </div>
        <div class="mt-3 d-grid">
            <button class="btn btn-primary waves-effect waves-light"
                type="submit">Login</button>
        </div>
    </form>
</div>
@endsection
