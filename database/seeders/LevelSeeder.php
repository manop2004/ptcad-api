<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_level')->insert(array(
            0=> array(
            'name' => 'แอดมิน',
            'number' => '1',
            'created_at' => now(),
            ),
            1=> array(
            'name' => 'นักเขียน',
            'number' => '2',
            'created_at' => now(),
            ),
            2=> array(
            'name' => 'นักพัฒนาและดูแลระบบ',
            'number' => '3',
            'created_at' => now(),
            ),
        ));
    }
}
