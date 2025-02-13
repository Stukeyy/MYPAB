<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tag;
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
            "firstname" => "admin",
            "lastname" => "user",
            "age" => 23,
            "gender" => "male",
            "location" => "down",
            "level" => "undergraduate",
            "institution" => "ulster university",
            "subject" => "interactive media, design & computing",
            "employed" => true,
            "email" => "admin@mail.com",
            "email_verified_at" => Carbon::now(),
            "password" => "password"
        ])->assignRole($admin);
        // Password hashed in User Model accessor

        $user = User::create([
            "firstname" => "demo",
            "lastname" => "user",
            "age" => 23,
            "gender" => "male",
            "location" => "down",
            "level" => "undergraduate",
            "institution" => "ulster university",
            "subject" => "interactive media, design & computing",
            "employed" => true,
            "email" => "demo@mail.com",
            "email_verified_at" => Carbon::now(),
            "password" => "password"
        ])->assignRole($admin);

        // $users = User::all();
        // foreach($users as $user) {

        //     // Base Tags

        //     $work = Tag::create([
        //         'name' => 'Work',
        //         'global' => true,
        //         'colour' => $faker->hexColor()
        //     ]);
        //     $user->tags()->attach($work->id);

        //     $life = Tag::create([
        //         'name' => 'Life',
        //         'global' => true,
        //         'colour' => $faker->hexColor()
        //     ]);
        //     $user->tags()->attach($life->id);

        // }

    }
}
