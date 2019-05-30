<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

      // create permissions
      Permission::create(['name' => 'register users']);
      Permission::create(['name' => 'view files']);
      Permission::create(['name' => 'create files']);
      Permission::create(['name' => 'edit files']);

      // create roles and assign created permissions
      // this can be done as separate statements
      $role = Role::create(['name' => 'secretary']);
      $role->givePermissionTo('view files');
      $role->givePermissionTo('create files');
      $role->givePermissionTo('edit files');

      $role = Role::create(['name' => 'doctor'])->givePermissionTo(['view files', 'edit files']);

      $role = Role::create(['name' => 'specialist-doctor'])->givePermissionTo(['view files', 'edit files']);

      $role = Role::create(['name' => 'lab-manager'])->givePermissionTo(['view files', 'edit files']);

      $role = Role::create(['name' => 'super-admin']);
      $role->givePermissionTo(Permission::all());
    }
}
