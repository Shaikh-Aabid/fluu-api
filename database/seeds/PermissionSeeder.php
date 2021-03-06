<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Permission::truncate();
    // Permission::create(['name' => 'Settings']); // 1
    Permission::create(['name' => 'Manage Dashboard']); // 1
    Permission::create(['name' => 'Manage Sites']); // 2
    Permission::create(['name' => 'Manage Users']); // 3
    Permission::create(['name' => 'Manage Permissions']); // 4
    Permission::create(['name' => 'Manage Values']); // 5
    Permission::create(['name' => 'Manage Value Lists']); // 6
    Permission::create(['name' => 'Manage VIQ Chapters']); // 7
    Permission::create(['name' => 'Manage Vessels']); // 8
    Permission::create(['name' => 'Manage Near Misses']); // 9
  }
}
