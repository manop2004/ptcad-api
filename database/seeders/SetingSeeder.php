<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_setting')->insert([
            'set_logoweb' => 'no-img-logo.png',
            'set_nameweb' => 'Name WEB',
            'update_by' => 'System',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
