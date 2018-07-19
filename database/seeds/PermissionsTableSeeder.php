<?php

use Illuminate\Database\Seeder;
use App\Permission;
// use DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ************************************
	    // Creating Permissions
	    // ************************************
	    $permissions = [
		    [
			    'name' => 'view-user',
			    'display_name' => 'View User',
			    'description' => 'User can view user list',
			    'group' => 'User Management',
			],[
			    'name' => 'add-user',
			    'display_name' => 'Add User',
			    'description' => 'User can add new user',
			    'group' => 'User Management',
			],[
			    'name' => 'update-user',
			    'display_name' => 'Update User',
			    'description' => 'User can update any users',
			    'group' => 'User Management',
			],[
			    'name' => 'view-role',
			    'display_name' => 'View Roles',
			    'description' => 'User can view role list',
			    'group' => 'User Management',
			],[
			    'name' => 'add-role',
			    'display_name' => 'Add Roles',
			    'description' => 'User can add new role',
			    'group' => 'User Management',
			],[
			    'name' => 'update-role',
			    'display_name' => 'Update Role',
			    'description' => 'User can update any roles',
			    'group' => 'User Management',
			],
		];

		DB::statement( 'SET FOREIGN_KEY_CHECKS=0;' );
		Permission::truncate();
		Permission::insert($permissions);
		DB::statement( 'SET FOREIGN_KEY_CHECKS=1;' );
    }
}
