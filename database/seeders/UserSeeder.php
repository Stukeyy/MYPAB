<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Create Roles and Permissions
        $admin = Role::create(['name' => 'admin']);
        $permission = Permission::create(['name' => 'all']);
        $admin->givePermissionTo($permission);

        $student = Role::create(['name' => 'student']);
        $permission = Permission::create(['name' => 'basic']);
        $student->givePermissionTo($permission);

        // Faker
        $faker = \Faker\Factory::create();

        // Users
        $user = User::create([
            "firstname" => "Stephen",
            "lastname" => "Ross",
            "email" => "stephenr.ross@yahoo.com",
            "email_verified_at" => Carbon::now(),
            "password" => Hash::make("password")
        ])->assignRole($admin);

    }
}
