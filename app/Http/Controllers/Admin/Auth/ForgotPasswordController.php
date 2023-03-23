<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\Http\Controllers\Traits\APIAuthenticatable;
use App\Services\Http\Controllers\Traits\Authenticatable;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use Authenticatable;
    use APIAuthenticatable;

    public function index()
    {
        return view('admin.auth.forgot-password');
    }

    public function store(Request $request)
    {
        if (isRequestForAPI() || $request->ajax()) {
            return $this->apiSendResetPasswordLink($request);
        }

        return $this->sendResetPasswordLink($request);
    }
}
