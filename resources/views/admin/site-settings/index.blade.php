@extends('layouts.app')

@section('title')
{{ config('app.name') }} | Site Settings
@endsection

@push('styles')
<link href="{{ asset('admin/assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css" />
@include('layouts.dropzone_css')
@endpush

@section('breadcrumb')
<div class="d-flex align-items-center pl-25">
    <h4 class="mb-0 header-top-heading">Site Settings</h4>
    <ul class="breadCamp-ul-class">
        <li>
            <a href="#"><img alt="home" src="{{ asset('admin/assets/images/home-line.svg') }}"></a>
        </li>
        <li>
            <i class="mdi mdi-chevron-right"></i>
        </li>
        <li>
            Site Settings
        </li>
    </ul>
</div>
@endsection

@section('content')
<form action="{{ route('admin.site-settings.store') }}" class="ajax-form" method="POST">
    @csrf
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-sm-0 font-size-16">Site Settings</h4>
        </div>
    </div>
    <div class="container-fluid">
        <div class="wd-90 sub-from-style">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="admin_primary_color" class="required">Admin Primary Color</label>
                    <input type="color" name="admin_primary_color" value="{{ $site_setting_admin_primary_color }}"
                        class="form-control form-control-color mw-100" placeholder="">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="admin_secondary_color" class="required">Admin Secondary Color</label>
                    <input type="color" name="admin_secondary_color" value="{{ $site_setting_admin_secondary_color }}" class="form-control form-control-color mw-100"
                        placeholder="">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="admin_site_favicon">Admin Site Favicon</label>
                    <div id="admin_site_favicon" class="fallback dropzone" data-accept="image/*"
                        data-name="admin_site_favicon">
                        <input name="admin_site_favicon" type="file" style="display: none;" />
                    </div>
                    <div class="file-path d-none"></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="admin_site_logo">Admin Site Logo</label>
                    <div id="admin_site_logo" class="fallback dropzone" data-accept="image/*"
                        data-name="admin_site_logo">
                        <input name="admin_site_logo" type="file" style="display: none;" />
                    </div>
                    <div class="file-path d-none"></div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="admin_footer_text">Admin Footer Text</label>
                    <input type="admin_footer_text" name="admin_footer_text"
                        value="{{ $site_setting_admin_footer_text }}" class="form-control" placeholder="">
                </div>
                <div class="col-md-12 mb-3">
                    <input type="submit" value="Update Settings" class="btn btn-primary">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('script-assets')
<script src="{{ asset('admin/assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
@include('layouts.dropzone_js')
@endpush
