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
        $role=\App\Role::create([
            'name'=>'super_admin'
        ]);
        foreach (\App\Permission::all() as $perm)
        {
            $role->permissions()->attach($perm->id,['activation'=>1]);
        }
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
