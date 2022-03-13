<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Tag;
use App\Models\Activity;

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

        // Random
        // $random = User::all()->random(1);

        // BASE TAGS ######################################################### // Created in User Seeder

        // $work = Tag::where('name', 'Work')->first();
        // $life = Tag::where('name', 'Life')->first();

        // WORK ##############################################################

        $users = User::all();
        foreach($users as $user) {

            // BASE TAGS #########################################################

            $colour = $faker->hexColor();
            $suggestedColour = $colour . '80';
            $work = Tag::create([
                'name' => 'Work',
                'global' => true,
                'colour' => $colour,
                'suggested' => $suggestedColour
            ]);
            $user->tags()->attach($work->id);

            $colour = $faker->hexColor();
            $suggestedColour = $colour . '80';
            $life = Tag::create([
                'name' => 'Life',
                'global' => true,
                'colour' => $colour,
                'suggested' => $suggestedColour
            ]);
            $user->tags()->attach($life->id);

            // WORK ##############################################################

            $colour = $faker->hexColor();
            $suggestedColour = $colour . '80';
            $education = Tag::create([
                'name' => 'Education',
                'global' => true,
                'parent_id' => $work->id,
                'colour' => $colour,
                'suggested' => $suggestedColour
            ]);
            $user->tags()->attach($education->id);
            $colour = $faker->hexColor();
            $suggestedColour = $colour . '80';
            $career = Tag::create([
                'name' => 'Career',
                'global' => true,
                'parent_id' => $work->id,
                'colour' => $colour,
                'suggested' => $suggestedColour
            ]);
            $user->tags()->attach($career->id);
                $colour = $faker->hexColor();
                $suggestedColour = $colour . '80';
                $portfolio = Tag::create([
                    'name' => 'Portfolio',
                    'global' => true,
                    'parent_id' => $career->id,
                    'colour' => $colour,
                    'suggested' => $suggestedColour
                ]);
                $user->tags()->attach($portfolio->id);
                $colour = $faker->hexColor();
                $suggestedColour = $colour . '80';
                $skills = Tag::create([
                    'name' => 'Skills',
                    'global' => true,
                    'parent_id' => $career->id,
                    'colour' => $colour,
                    'suggested' => $suggestedColour
                ]);
                $user->tags()->attach($skills->id);

            // LIFE ##############################################################

            $colour = $faker->hexColor();
            $suggestedColour = $colour . '80';
            $physical = Tag::create([
                'name' => 'Physical',
                'global' => true,
                'parent_id' => $life->id,
                'colour' => $colour,
                'suggested' => $suggestedColour
            ]);
            $user->tags()->attach($physical->id);
            $colour = $faker->hexColor();
            $suggestedColour = $colour . '80';
            $social = Tag::create([
                'name' => 'Social',
                'global' => true,
                'parent_id' => $life->id,
                'colour' => $colour,
                'suggested' => $suggestedColour
            ]);
            $user->tags()->attach($social->id);
            $colour = $faker->hexColor();
            $suggestedColour = $colour . '80';
            $self = Tag::create([
                'name' => 'Self',
                'global' => true,
                'parent_id' => $life->id,
                'colour' => $colour,
                'suggested' => $suggestedColour
            ]);
            $user->tags()->attach($self->id);
                $colour = $faker->hexColor();
                $suggestedColour = $colour . '80';
                $holiday = Tag::create([
                    'name' => 'Holiday',
                    'global' => true,
                    'parent_id' => $self->id,
                    'colour' => $colour,
                    'suggested' => $suggestedColour
                ]);
                $user->tags()->attach($holiday->id);

            // ACTIVITIES

            $activity = Activity::create([
                'name' => 'Go for a run',
                'global' => true,
                'tag_id' => $physical->id
            ]);
            $user->activities()->attach($activity->id);

            $activity = Activity::create([
                'name' => 'Read a book',
                'global' => true,
                'tag_id' => $self->id
            ]);
            $user->activities()->attach($activity->id);

            $activity = Activity::create([
                'name' => 'Meditate',
                'global' => true,
                'tag_id' => $self->id
            ]);
            $user->activities()->attach($activity->id);


            $activity = Activity::create([
                'name' => 'Meet up with friends',
                'global' => true,
                'tag_id' => $social->id
            ]);
            $user->activities()->attach($activity->id);

            $activity = Activity::create([
                'name' => 'Learn a new skill',
                'global' => true,
                'tag_id' => $skills->id
            ]);
            $user->activities()->attach($activity->id);

        }


    }
}
