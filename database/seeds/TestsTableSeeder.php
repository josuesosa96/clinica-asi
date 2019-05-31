<?php

use Illuminate\Database\Seeder;

class TestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('tests')->insert([
        'name' => 'Hemograma completo'
      ]);
      DB::table('tests')->insert([
        'name' => 'Urinálisis completo'
      ]);
      DB::table('tests')->insert([
        'name' => 'Perfil lipídico'
      ]);
      DB::table('tests')->insert([
        'name' => 'Exámen de heces'
      ]);
      DB::table('tests')->insert([
        'name' => 'Perfil hepático'
      ]);
    }
}
