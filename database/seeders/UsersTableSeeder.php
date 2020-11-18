<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developer = Role::create([
            'name'       => 'developer',
        ]);

        $user = User::create([
            'name'      => 'Developer',
            'username'  => 'Dev 4vm',
            'email'     => 'developer@gmail.com',
            'password'  => Hash::make('password'),
        ]);

        $user->assignRole($developer);
    }
}
