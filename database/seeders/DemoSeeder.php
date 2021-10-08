<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Tag;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Faker
        $faker = \Faker\Factory::create();

        // BASE TAGS - MUST BE SEEDED FIRST IN ORDER AS THEY ARE THEIR OWN PARENTS

        $work = Tag::create([
            'name' => 'Work',
            'global' => true,
            'parent_id' => 1,
            'colour' => $faker->hexColor()
        ]);

        $life = Tag::create([
            'name' => 'Life',
            'global' => true,
            'parent_id' => 2,
            'colour' => $faker->hexColor()
        ]);

        // WORK

        $education = Tag::create([
            'name' => 'Education',
            'global' => true,
            'parent_id' => $work->id,
            'colour' => $faker->hexColor()
        ]);

        $career = Tag::create([
            'name' => 'Career',
            'global' => true,
            'parent_id' => $work->id,
            'colour' => $faker->hexColor()
        ]);
        $portfolio = Tag::create([
            'name' => 'Portfolio',
            'global' => true,
            'parent_id' => $career->id,
            'colour' => $faker->hexColor()
        ]);

        // LIFE

        $tag = Tag::create([
            'name' => 'Physical',
            'global' => true,
            'parent_id' => $life->id,
            'colour' => $faker->hexColor()
        ]);

        $tag = Tag::create([
            'name' => 'Social',
            'global' => true,
            'parent_id' => $life->id,
            'colour' => $faker->hexColor()
        ]);

        $tag = Tag::create([
            'name' => 'Self',
            'global' => true,
            'parent_id' => $life->id,
            'colour' => $faker->hexColor()
        ]);


    }
}
