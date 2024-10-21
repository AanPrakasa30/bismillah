<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'super admin BK',
            'email' => 'super@bk.admin',
            'password' => 123123
        ]);

        UserProfile::create([
            'user_id' => $superAdmin->id
        ]);
    }
}
