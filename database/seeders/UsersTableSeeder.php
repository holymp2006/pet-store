<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'admin@buckhill.co.uk',
            'password' => 'admin',
            'is_admin' => Role::ADMIN,
        ]);
        User::factory()->create([
            'email' => 'user@buckhill.co.uk',
            'password' => 'userpassword',
        ]);
    }
}
