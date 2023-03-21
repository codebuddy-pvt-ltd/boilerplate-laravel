<?php

namespace App\Services\Http\Controllers\Traits;

use App\Services\Http\Response\APIResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

trait APIAuthenticatable
{
    public function apiAuthenticate(Request $request): void
    {
        $request->authenticate();
    }

    public function apiSendResetPasswordLink(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return APIResponse::build()
                ->status('success')
                ->message(__($status))
                ->clearForm()
                ->send();
        } else {
            return APIResponse::build()
                ->status('error')
                ->errors([
                    'email' => __($status),
                ])
                ->send();
        }
    }
}
