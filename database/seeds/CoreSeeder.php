<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sources')->insert([
            [ 'name' => 'Baseball America' ],
            [ 'name' => 'MLB' ],
            [ 'name' => 'Perfect Game' ],
        ]);
        DB::table('classifications')->insert([
            ['name' => 'HS'],
            ['name' => '4yr'],
            ['name' => 'JC'],
            ['name' => 'N/A'],
        ]);
        DB::table('positions')->insert([
            [ 'name' => '1B' ],
            [ 'name' => '2B' ],
            [ 'name' => '3B' ],
            [ 'name' => 'SS' ],
            [ 'name' => 'C'  ],
            [ 'name' => 'OF' ],
            [ 'name' => 'LHP' ],
            [ 'name' => 'RHP' ],
        ]);
    }
}
