<?php

use Illuminate\Database\Seeder;

class permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Permission::create([
            'name'=>'create_user',
            'description'=>'create_user'
        ]);
        \App\Permission::create([
            'name'=>'delete_user',
            'description'=>'delete_user'
        ]);
        \App\Permission::create([
            'name'=>'update_user',
            'description'=>'update_user'
        ]);
        \App\Permission::create([
            'name'=>'create_post',
            'description'=>'create_post'
        ]);
        \App\Permission::create([
            'name'=>'delete_post',
            'description'=>'delete_post'
        ]);
        \App\Permission::create([
            'name'=>'update_post',
            'description'=>'update_post'
        ]);
        \App\Permission::create([
            'name'=>'create_comment',
            'description'=>'create_comment'
        ]);
        \App\Permission::create([
            'name'=>'delete_comment',
            'description'=>'delete_comment'
        ]);
        \App\Permission::create([
            'name'=>'update_comment',
            'description'=>'update_comment'
        ]);


    }
}
