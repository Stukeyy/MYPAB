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

        $work = Tag::where('name', 'Work')->first();
        $life = Tag::where('name', 'Life')->first();

        // WORK ##############################################################

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
            $skills = Tag::create([
                'name' => 'Skills',
                'global' => true,
                'parent_id' => $career->id,
                'colour' => $faker->hexColor()
            ]);

        // LIFE ##############################################################

        $physical = Tag::create([
            'name' => 'Physical',
            'global' => true,
            'parent_id' => $life->id,
            'colour' => $faker->hexColor()
        ]);
        $social = Tag::create([
            'name' => 'Social',
            'global' => true,
            'parent_id' => $life->id,
            'colour' => $faker->hexColor()
        ]);
        $self = Tag::create([
            'name' => 'Self',
            'global' => true,
            'parent_id' => $life->id,
            'colour' => $faker->hexColor()
        ]);
            $a = Tag::create([
                'name' => 'A',
                'global' => true,
                'parent_id' => $self->id,
                'colour' => $faker->hexColor()
            ]);
            $b = Tag::create([
                'name' => 'B',
                'global' => true,
                'parent_id' => $self->id,
                'colour' => $faker->hexColor()
            ]);
            $c = Tag::create([
                'name' => 'C',
                'global' => true,
                'parent_id' => $self->id,
                'colour' => $faker->hexColor()
            ]);
                $d = Tag::create([
                    'name' => 'D',
                    'global' => true,
                    'parent_id' => $c->id,
                    'colour' => $faker->hexColor()
                ]);
                    $e = Tag::create([
                        'name' => 'E',
                        'global' => true,
                        'parent_id' => $d->id,
                        'colour' => $faker->hexColor()
                    ]);


        // ACTIVITIES

        $activity = Activity::create([
            'name' => 'Go for a run',
            'global' => true,
            'tag_id' => $physical->id
        ]);

        $activity = Activity::create([
            'name' => 'Read a book',
            'global' => true,
            'tag_id' => $self->id
        ]);

        $activity = Activity::create([
            'name' => 'Meditate',
            'global' => true,
            'tag_id' => $self->id
        ]);

        $activity = Activity::create([
            'name' => 'Meet up with friends',
            'global' => true,
            'tag_id' => $social->id
        ]);

        $activity = Activity::create([
            'name' => 'Learn a new skill',
            'global' => true,
            'tag_id' => $skills->id
        ]);


        // USER

        $x = Activity::create([
            'name' => 'X',
            'global' => true,
            'tag_id' => $a->id
        ]);
        $y = Activity::create([
            'name' => 'Y',
            'global' => true,
            'tag_id' => $b->id
        ]);
        $z = Activity::create([
            'name' => 'Z',
            'global' => true,
            'tag_id' => $c->id
        ]);

        $user = User::find(1);
        $user->tags()->attach([$a->id, $b->id, $c->id, $d->id, $e->id]);
        $user->activities()->attach([$x->id, $y->id, $z->id]);


    }
}
