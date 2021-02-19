<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => "IdU00001",
            'fullname' => 'Owner',
            'username' => 'owner',
            'email' => 'owner@gmail.com',
            'password' => md5('123456'),
            'is_active' => true,
            'is_success' => false,
            'api_token' => '',
            'user_role_id' => 'IdUG00001',
            'users_id' => '1235'
]);
        $this->call(CambodiaAddress::class);
    }
}
