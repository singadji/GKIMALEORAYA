<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@gkimaleoraya.org',
            'password' => bcrypt(env('ADMIN_PASSWORD', Str::random(16))),
            'type' => 'Administrator',
            'aktif' => 'Y',
        ]);
    }
}
