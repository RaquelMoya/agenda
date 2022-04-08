<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notes')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'user_id' => rand(1, 2)
        ]);

        DB::table('notes')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'user_id' => rand(1, 2)
        ]);

        DB::table('notes')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'user_id' => rand(1, 2)
        ]);
    }
}
