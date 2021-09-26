<?php

namespace Database\Seeders;

use App\Models\comment;
use App\Models\Film;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Factory::create();
        for ($i = 0; $i < 3; $i++) {
            $userId = User::inRandomOrder()->first()->pluck('id');
            $film = new Film();
            $film->name = "Test film $i";
            $film->description = "Test film $i";
            $film->release_date = "2019-10-10";
            $film->rating = "5";
            $film->ticket_price = "10";
            $film->country = "USA";
            $film->photo = "storage/photo/test_film";
            $film->save();
            $comment = new comment();
            $comment->user_id = $userId[0];
            $comment->comment = "its very nice";
            $film->comments()->save($comment);
            echo $i;
        }
    }
}
