<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $permissions = [
//           'Dashboard',
//            'Lms',
//        ];
//
//        foreach ($permissions as $permission) {
//             $ret=Permission::create(['name' => $permission, 'form'=>0, 'menu'=>1]);
//            $fixstr=str_replace(' ', '_', strtolower($permission));
//            Permission::create(['name' => $fixstr.'_view', 'parent_id'=>$ret->id]);
//        }
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'0', 'name' => 'Dashboard', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'1', 'name' => 'dashboard_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'0', 'name' => 'User', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'2', 'name' => 'user_list_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'2', 'name' => 'user_list_create', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'2', 'name' => 'user_list_edit', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'2', 'name' => 'user_list_delete', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'0', 'name' => 'Role', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'3', 'name' => 'role_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'3', 'name' => 'role_create', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'3', 'name' => 'role_edit', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'3', 'name' => 'role_delete', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);

    }
}
