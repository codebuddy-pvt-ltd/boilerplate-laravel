<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\Auth\ChangePasswordRequest;
use App\Models\User;
use App\Services\Entities\User\UserService;
use App\Services\Http\Controllers\Traits\APIAuthenticatable;
use App\Services\Http\Controllers\Traits\Authenticatable;
use App\Services\Http\Response\APIResponse;

class ChangePasswordController extends Controller
{
    use Authenticatable;
    use APIAuthenticatable;

    public function index()
    {
        return view('admin.auth.change-password');
    }

    public function store(ChangePasswordRequest $request, UserService $userService)
    {
        /** @var User */
        $user = auth()->user();

        $res = $userService->updatePassword($user, $request->old_password, $request->password);

        if (!$res) {
            return APIResponse::build()
                ->status('error')
                ->errors([
                    'old_password' => ['Password didn\'t match!'],
                ])
                ->send();
        }

        if (isRequestForAPI()) {
            $user->createToken('API Token')->accessToken;

            return APIResponse::build()
                ->status('success')
                ->message('Password updated successfully!')
                ->send();
        }

        $this->logout($request);

        return APIResponse::build()
            ->status('success')
            ->clearForm()
            ->message('Password updated successfully!')
            ->redirectTo(route('admin.login.index'))
            ->send();
    }
}
