<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActorSeeder extends Seeder
{
    public function run()
    {
        $actors = json_decode(file_get_contents(public_path('actors.json')), true);

        foreach ($actors as $actor) {
            DB::table('actors')->updateOrInsert(
                ['name' => $actor['name']],
                [
                    'photo_url' => $actor['photo_url'] ?? null,
                    'popularity' => $actor['popularity'] ?? null,
                ]
            );
        }
    }
}