<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $genres = json_decode(file_get_contents(public_path('genres.json')), true);

        foreach ($genres as $genre) {
            DB::table('genres')->updateOrInsert(['name' => $genre]);
        }
    }
}