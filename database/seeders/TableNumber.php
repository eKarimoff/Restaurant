<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TableNumber extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <15; $i++){
            DB::table('table')->insert([
            'number' => $i,
            'created_at' =>now()->toDateTimeString(),
            'updated_at' =>now()->toDateTimeString(),
            ]);
        }
    }
}
