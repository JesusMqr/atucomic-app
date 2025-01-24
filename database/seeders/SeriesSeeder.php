<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Serie;
use App\Models\Chapter;
use App\Models\Image;
use Spatie\Permission\Models\Role;

class SeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'Colaborador']);


        User::factory(5)->create()->each(function ($user) use ($role) {
      
            $user->assignRole('Colaborador');


            $seriesCount = rand(2, 4);
            Serie::factory($seriesCount)->create([
                'owner_id' => $user->id
            ])->each(function ($series) use ($user) {
   
                $chapterCount = rand(3, 5);
                Chapter::factory($chapterCount)->create([
                    'owner_id' => $user->id,
                    'serie_id' => $series->id
                ])->each(function ($chapter) use ($user) {

                    $imageCount = rand(8, 10);
                    Image::factory($imageCount)->create([
                        'owner_id' => $user->id,
                        'chapter_id' => $chapter->id
                    ]);
                });
            });
        });
    }
}
