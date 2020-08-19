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
            'name'=>'super powersManagement',
            'email'=>'super_admin@powersManagement.com',
            'password'=>bcrypt('12345678'),
        ]);
    }
}
