<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\User\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $resetPasswordUrl = '';

        if ($this->isSuperAdmin()) {
            $resetPasswordUrl = route('admin.reset-password.show', ['token' => $token]);
        }

        if (empty($resetPasswordUrl)) {
            throw new \Exception('No password reset url found!');
        }

        $this->notify(new ResetPasswordNotification($resetPasswordUrl));
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(config('roles.super_admin.value'));
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
