<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User */
        $user = User::updateOrCreate([
            'email' => config('app-config.admin-email'),
        ], [
            'first_name' => config('app-config.admin-first-name'),
            'last_name' => config('app-config.admin-last-name'),
            'password' => Hash::make(config('app-config.admin-password')),
        ]);

        $user->syncRoles(config('roles.super_admin.value'));
    }
}
