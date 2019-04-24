<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        'name' => 'Admin',
        'user_name' => 'admin',
        'password' => bcrypt('admin')
      ]);
      DB::table('users')->insert([
        'name' => 'Secretaria Administrativa1',
        'user_name' => 'secAdmin1',
        'password' => bcrypt('secAdmin1')
      ]);
      DB::table('users')->insert([
        'name' => 'Medico General1',
        'user_name' => 'medGen1',
        'password' => bcrypt('medGen1')
      ]);
      DB::table('users')->insert([
        'name' => 'Encargado Laboratorio1',
        'user_name' => 'encLab1',
        'password' => bcrypt('encLab1')
      ]);
    }
}
