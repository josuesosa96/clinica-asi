<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //admin
      DB::table('model_has_roles')->insert([
        'role_id' => 5,
        'model_type' => 'App\User',
        'model_id' => 1
      ]);
      //doctor1
      DB::table('model_has_roles')->insert([
        'role_id' => 2,
        'model_type' => 'App\User',
        'model_id' => 3
      ]);
      //doctor especialista1
      DB::table('model_has_roles')->insert([
        'role_id' => 3,
        'model_type' => 'App\User',
        'model_id' => 4
      ]);
      //secretaria
      DB::table('model_has_roles')->insert([
        'role_id' => 1,
        'model_type' => 'App\User',
        'model_id' => 2
      ]);
      //Encargado Lab
      DB::table('model_has_roles')->insert([
        'role_id' => 4,
        'model_type' => 'App\User',
        'model_id' => 5
      ]);
    }
}
