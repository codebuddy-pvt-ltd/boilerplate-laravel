<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\Http\Controllers\Traits\Authenticatable;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use Authenticatable;

    public function destroy(Request $request)
    {
        $this->logout($request);

        return redirect(route('admin.login.index'));
    }
}
