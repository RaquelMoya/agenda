<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert([
            'name' => Str::random(10),
            'surname' => Str::random(10),
            'phone' => '615544165',
            'email' => Str::random(10).'@gmail.com',
            'user_id' => rand(1, 2)
        ]);

        DB::table('contacts')->insert([
            'name' => Str::random(10),
            'surname' => Str::random(10),
            'phone' => '145465155',
            'email' => Str::random(10).'@gmail.com',
            'user_id' => rand(1, 2)
        ]);
    }
}
