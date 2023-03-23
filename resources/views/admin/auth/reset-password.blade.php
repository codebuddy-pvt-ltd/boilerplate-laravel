@extends('layouts.admin-auth')

@section('title')
{{ config('app.name') }} | Reset Password
@endsection

@section('card-title')
<h5 class="text-h5">Reset password</h5>
@endsection

@section('content')
<div class="p-2">
    <form class="form-horizontal ajax-form" action="{{ route('admin.reset-password.store') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-4">
            <label for="email" class="form-label">Email <sup>*</sup></label>
            <input type="email" name="email" class="form-control" id="email"
                placeholder="Enter your email">
        </div>
        <div class="mb-4">
            <label id="password" class="form-label">New Password <sup>*</sup></label>
            <input type="password" name="password" class="form-control" id="password"
                placeholder="New password">
        </div>
        <div class="mb-4">
            <label id="password_confirmation" class="form-label">Confirm Password <sup>*</sup></label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">
        </div>
        <div class="mt-3 d-grid">
            <button class="btn btn-primary waves-effect waves-light"
                type="submit">Change Password</button>
        </div>
    </form>
</div>
@endsection
