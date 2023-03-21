<?php

namespace App\Services\Entities\User;

use App\Models\User;
use App\Services\Model\Traits\CrudService;
use Illuminate\Support\Facades\Hash;

class UserService
{
    use CrudService;

    public function updatePassword(User $user, string $oldPassword, string $password): bool
    {
        if (!Hash::check($oldPassword, $user->password)) {
            return false;
        }

        $user->password = Hash::make($password);
        $user->save();

        return true;
    }
}
