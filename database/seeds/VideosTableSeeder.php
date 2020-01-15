<?php

use Illuminate\Database\Seeder;
use \App\Models\Video;
use \App\Models\Genre;
class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = Genre::all();
        factory(Video::class, 100)
            ->create()
            ->each(function (Video $video) use ($genres) {
                $subGenres = $genres->random(5)->load('categories');
                $categoriesId = [];
                foreach ($subGenres as $genre){
                    array_push($categoriesId, ...$genre->categories()->pluck('id')->toArray());
                }
                $categoriesId = array_unique($categoriesId);
                $video->categories()->attach($categoriesId);
                $video->genres()->attach($subGenres->pluck('id')->toArray());
            });
    }
}
