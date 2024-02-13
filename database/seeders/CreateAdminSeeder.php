<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Superbruker',
            'profile_img' => '1.png',
            'email' => 'support1@alexsol.tk',
            'password' => '256487502Ab,',
            'phone' => '5436096271',
            'user_type' => 'admin_super',
        ]);
    }
}
