@extends('layouts.app')

@section('title')
{{ config('app.name') }} | Change Password
@endsection

@section('content')
<form action="{{ route('admin.change-password.store') }}" class="ajax-form" method="POST">
    @csrf
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-sm-0 font-size-16">Change Password</h4>
        </div>
    </div>
    <div class="container-fluid">
        <div class="wd-90 sub-from-style">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="old_password">Old Password</label>
                        <input type="password" name="old_password" class="form-control" placeholder="">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password_confirmation">New Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="">
                    </div>
                    <div class="form-group mb-3">
                        <input type="submit" value="Change Password" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
