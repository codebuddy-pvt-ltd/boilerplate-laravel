<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(config('roles'))->map(function ($value) {
            Role::updateOrCreate([
                'name' => $value['value'],
            ]);
        });
    }
}
