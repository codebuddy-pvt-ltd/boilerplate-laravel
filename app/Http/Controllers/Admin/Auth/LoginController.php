<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\Http\Controllers\Traits\APIAuthenticatable;
use App\Services\Http\Controllers\Traits\Authenticatable;
use App\Services\Http\Response\APIResponse;

class LoginController extends Controller
{
    use Authenticatable;
    use APIAuthenticatable;

    public function index()
    {
        return view('admin.auth.login');
    }

    public function store(LoginRequest $request)
    {
        if (isRequestForAPI()) {
            $this->apiAuthenticate($request);

            /** @var User */
            $user = auth()->user();

            $token = $user->createToken('API Token')->accessToken;

            return APIResponse::build()
                ->status('success')
                ->data([
                    'user' => $user,
                    'token' => $token,
                ])
                ->send();
        }

        $this->authenticateAndRegenerateToken($request);

        if ($request->ajax()) {
            return APIResponse::build()
                ->status('success')
                ->message('You\'re successfully logged in!')
                ->messageDisplayDuration(1000)
                ->refresh()
                ->send();
        }

        return redirect()->intended(route('admin.dashboard.index'));
    }
}
