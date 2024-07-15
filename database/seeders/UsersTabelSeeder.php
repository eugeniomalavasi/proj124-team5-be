<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersData = config('user-data');
        foreach ($usersData as $userData) {
            $newUser = new User();
            $newUser->fill($userData);
            $newUser->save();
        }
    }
}
