<?php

namespace Database\Seeders;

use App\Models\User;
use App\Utils\Enums\User\UserRoleEnum;
use App\Utils\Enums\User\UserStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->generateDefaultUsers();
        $this->generateDefaultRolesAndAttachToUsers();
    }

    private function generateDefaultUsers()
    {
        DB::table('users')->delete();

        $users = [
            [
                'name' => 'Super Admin',
                'email' => config('common.super_admin.email'),
                'password' => Hash::make('!Qwerty123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Patient',
                'email' => config('common.patient.email'),
                'password' => Hash::make('!Qwerty123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('users')->insert($users);
    }

    private function generateDefaultRolesAndAttachToUsers()
    {
        Role::query()->delete();
        Permission::query()->delete();


        $guard = 'api';
        $roles = [
            UserRoleEnum::SUPER_ADMIN => Role::create([
                'name' => UserRoleEnum::SUPER_ADMIN,
                'guard_name' => $guard
            ]),
            UserRoleEnum::PATIENT => Role::create([
                'name' => UserRoleEnum::PATIENT,
                'guard_name' => $guard
            ])
        ];

        $userIdCnt = 1;
        foreach ($roles as $roleKey => $role) {
            if (config('permission.seeder.' . $roleKey)) {
                foreach (config('permission.seeder.' . $roleKey) as $key => $perm) {
                    if (!$permission = Permission::whereName($key)->whereGuardName($guard)->first()) {
                        $permission = Permission::create([
                            'name' => $key,
                            'guard_name' => $guard
                        ]);
                    }

                    $role->givePermissionTo($permission);
                }

                $user = User::find($userIdCnt);
                if (!is_null($user)) {
                    $user->assignRole($role);
                }

                $userIdCnt++;
            }
        }
    }
}
