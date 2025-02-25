<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password'),
            'username' => 'johndoe',
            'bio' => 'This is a sample bio.',
        ]);
    }
}
