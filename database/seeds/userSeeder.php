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
            'name'=>'super',
            'email'=>'super_admin@admin.com',
            'password'=>bcrypt('12345678'),
        ]);
        foreach (\App\Permission::all() as $perm)
        {
            $user->permissions()->attach($perm->id,['activation'=>1]);
        }
        $user->roles()->attach(\App\Role::where('name','super_admin')->first()->id,['activation'=>1]);
    }
}
