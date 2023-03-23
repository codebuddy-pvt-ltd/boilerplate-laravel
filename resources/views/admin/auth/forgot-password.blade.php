@extends('layouts.admin-auth')

@section('title')
{{ config('app.name') }} | Forgot Password
@endsection

@section('card-title')
<h5 class="text-h5">Forgot Password?</h5>
<span class="sub-text">Please enter your email id for a password reset link</span>
@endsection

@section('content')
<div class="p-2">
    <form class="form-horizontal ajax-form" action="{{ route('admin.forgot-password.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="email" class="form-label">Email <sup>*</sup></label>
            <input type="email" name="email" class="form-control" id="email"
                placeholder="Enter your email">
        </div>
        <div class="mt-3 d-grid">
            <button class="btn btn-primary waves-effect waves-light"
                type="submit">Submit</button>
        </div>
    </form>
    <div class="text-center mt-5"><a href="{{ route('admin.login.index') }}" class="back-link"><i class="mdi mdi-chevron-left"></i> Back to Login</a></div>
</div>
@endsection
