<div data-simplebar class="h-100">
    <div id="sidebar-menu">
        <ul class="metismenu list-unstyled" id="side-menu">

            @include('layouts.menu')

        </ul>
        {{-- <ul class="metismenu list-unstyled" id="side-menu">

            <li>
                <a href="index.html" class="waves-effect">
                    <img alt="Dashboard" src="assets/images/dashboard1.svg" class="default-icon">
                    <img alt="Dashboard" src="assets/images/dashboard2.svg" class="hover-icon">
                    <span key="t-dashboards">Dashboard</span>
                </a>

            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <img alt="Masters" src="assets/images/masters1.svg" class="default-icon">
                    <img alt="Masters" src="assets/images/masters2.svg" class="hover-icon">
                    <span key="t-email">Masters</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="product-type.html">Product type</a></li>
                    <li><a href="brands.html">Brands</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <img alt="Distributors" src="assets/images/distributors1.svg" class="default-icon">
                    <img alt="Distributors" src="assets/images/distributors2.svg" class="hover-icon">
                    <span key="t-email">Distributors</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="distributors.html">Personal Details</a></li>

                </ul>
            </li>

            <li>
                <a href="form-elements.html" class="waves-effect">
                    <img alt="Distributors" src="assets/images/credit-card1.svg" class="default-icon">
                    <img alt="Distributors" src="assets/images/credit-card2.svg" class="hover-icon">

                    <span key="t-file-invoices">Subscription plans</span>
                </a>
            </li>

        </ul> --}}
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