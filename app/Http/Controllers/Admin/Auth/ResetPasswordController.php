<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\Http\Controllers\Traits\Authenticatable;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use Authenticatable;

    public function show(Request $request)
    {
        return view('admin.auth.reset-password', [
            'token' => $request->token,
        ]);
    }

    public function store(Request $request)
    {
        if (isRequestForAPI() || $request->ajax()) {
            return $this->resetPasswordAPI($request);
        }

        return $this->resetPassword($request, route('admin.login.index'));
    }
}
