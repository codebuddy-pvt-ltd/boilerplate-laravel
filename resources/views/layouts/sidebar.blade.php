<div data-simplebar class="h-100">
    <div id="sidebar-menu">
        <ul class="metismenu list-unstyled" id="side-menu">
            @include('layouts.menu')
        </ul>
    </div>
    <div class="btm-profile-section">
        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle btm-profile-user" src="{{ asset('admin/assets/images/users/avatar-1.jpg') }}"
                    alt="Header Avatar">
                <span class="d-xl-inline-block ms-1 text-left">
                    <h5>Amy Horsefighter</h5>
                    <span>abc@gmail.com</span>
                </span>
                <i class="mdi mdi-chevron-right d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end text-right">
                <a class="dropdown-item text-danger" href="login.html">
                    <span key="t-logout">Logout</span></a>
            </div>
        </div>
    </div>
</div>