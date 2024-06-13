<?php

namespace Database\Seeders;

use App\Models\User;
use App\Utils\Enums\User\UserRoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PatientsSeeder extends Seeder
{
    private Role $role;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->role = Role::whereName(UserRoleEnum::PATIENT)->first();

        $users = User::factory()->count(10)->create();

        $users->each(function (User $user) {
            $user->assignRole($this->role);
        });
    }
}
