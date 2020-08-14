<?php

use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=\App\User::create([
            'name'=>'super admin',
            'email'=>'super_admin@admin.com',
            'password'=>bcrypt('12345678'),
            'group_id'=>1
        ]);
        $user->attachRole('super_admin');
    }
}
