<?php

use App\Entity\User;
use App\Entity\Link;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LinksTableSeeder extends Seeder
{
    public function run(){
        $faker = Faker::create();
        $users = User::all()->pluck('id')->toArray();
        foreach(range(1,30) as $index){
            $link = Link::create([
                'link' => $faker->url,
                'user_id' => $faker->randomElement($users),
                'title' => $faker->title,
                'description' => $faker->text,
                'private' => $faker->boolean,
            ]);
        }
    }
}
