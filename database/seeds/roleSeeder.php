<?php

use Illuminate\Database\Seeder;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Role::create([
            'name'=>'super_admin'
        ]);
        \App\Role::create([
            'name'=>'powersManagement'
        ]);
        \App\Role::create([
            'name'=>'publisher'
        ]);
        \App\Role::create([
            'name'=>'checker'
        ]);

    }
}
