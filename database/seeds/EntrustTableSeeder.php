<?php

use App\Models\Permission;
use App\Models\Role;
use App\User;
use Illuminate\Database\Seeder;

class EntrustTableSeeder extends Seeder {

	public function run()
	{

		DB::table('role_user')->truncate();
		DB::table('permission_role')->truncate();
		DB::table('roles')->truncate();
		DB::table('permissions')->truncate();

		$admin = new Role(); // 1
		$admin->name = 'admin';
		$admin->display_name = "Administrator";
		$admin->level = 10;
		$admin->save();

		$editor = new Role(); // 2
		$editor->name = 'editor';
		$editor->display_name = "Editor";
		$editor->level = 5;
		$editor->save();

		$userRole = new Role(); // 3
		$userRole->name = 'user';
		$userRole->display_name = "User";
		$userRole->level = 1;
		$userRole->save();

		$user = User::where('email', '=', 'admin@admin.com')->first();
		$user->attachRole($admin);
		//$user->roles()->attach($admin->id); Eloquent basic

		$user1 = User::where('email', '=', 'editor@editor.com')->first();
		$user1->attachRole($editor);

		$user2 = User::where('email', '=', 'user@user.com')->first();
		$user2->attachRole($userRole);

		$manageRoles = new Permission();
		$manageRoles->name = 'manage_roles';
		$manageRoles->display_name = "Manage roles";
		$manageRoles->description = "";
		$manageRoles->save();

		$manageUsers = new Permission();
		$manageUsers->name = 'manage_users';
		$manageUsers->display_name = "Manager users";
		$manageUsers->description = "Manage users";
		$manageUsers->save();

		$managePerms = new Permission();
		$managePerms->name = 'manage_permissions';
		$managePerms->display_name = "Manage permissions";
		$managePerms->description = "";
		$managePerms->save();

		$admin->attachPermissions([$manageRoles, $manageUsers, $managePerms]);
		//$admin->perms()->sync([$manageRoles->id, $manageUsers->id, $managePerms->id]); Eloquent basic

		$editor->attachPermission($manageUsers);
	}

}