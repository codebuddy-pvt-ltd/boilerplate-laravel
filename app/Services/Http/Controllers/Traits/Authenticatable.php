<?php

namespace App\Services\Http\Controllers\Traits;

use App\Models\User;
use App\Services\Http\Response\APIResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as RulePassword;

trait Authenticatable
{
    public function authenticateAndRegenerateToken(Request $request): void
    {
        $request->authenticate();

        $request->session()->regenerate();
    }

    public function sendResetPasswordLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }

    private function resetPasswordImplementation(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', RulePassword::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        return Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );
    }

    public function resetPassword(Request $request, string $loginUrl): RedirectResponse
    {
        $status = $this->resetPasswordImplementation($request);

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
            ? redirect($loginUrl)->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }

    public function resetPasswordAPI(Request $request): JsonResponse
    {
        $status = $this->resetPasswordImplementation($request);

        if ($status == Password::PASSWORD_RESET) {
            /** @var User */
            $user = User::firstWhere('email', $request->email);

            $response = APIResponse::build()
                ->status('success')
                ->message(__($status))
                ->messageDisplayDuration(2000)
                ->clearForm();

            if ($user->isSuperAdmin()) {
                $response = $response->redirectTo(route('admin.login.index'));
            }

            return $response->send();
        } else {
            return APIResponse::build()
                ->status('error')
                ->errors([
                    'email' => [__($status)],
                ])
                ->send();
        }
    }

    public function logout(Request $request): void
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
