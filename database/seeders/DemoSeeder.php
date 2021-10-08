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
            'ancestor_id' => $work->ancestor_id,
            'parent_id' => $work->id,
            'descendants' => 0,
            'generation' => ($work->generation + 1),
            'colour' => $faker->hexColor()
        ]);
        $career = Tag::create([
            'name' => 'Career',
            'global' => true,
            'ancestor_id' => $work->ancestor_id,
            'parent_id' => $work->id,
            'descendants' => 0,
            'generation' => ($work->generation + 1),
            'colour' => $faker->hexColor()
        ]);
        $work->increment('descendants');
            $portfolio = Tag::create([
                'name' => 'Portfolio',
                'global' => true,
                'ancestor_id' => $career->ancestor_id,
                'parent_id' => $career->id,
                'descendants' => 0,
                'generation' => ($career->generation + 1),
                'colour' => $faker->hexColor()
            ]);
            $skills = Tag::create([
                'name' => 'Skills',
                'global' => true,
                'ancestor_id' => $career->ancestor_id,
                'parent_id' => $career->id,
                'descendants' => 0,
                'generation' => ($career->generation + 1),
                'colour' => $faker->hexColor()
            ]);
            $work->increment('descendants');
            $career->increment('descendants');

        // LIFE ##############################################################

        $physical = Tag::create([
            'name' => 'Physical',
            'global' => true,
            'ancestor_id' => $life->ancestor_id,
            'parent_id' => $life->id,
            'descendants' => 0,
            'generation' => ($life->generation + 1),
            'colour' => $faker->hexColor()
        ]);
        $social = Tag::create([
            'name' => 'Social',
            'global' => true,
            'ancestor_id' => $life->ancestor_id,
            'parent_id' => $life->id,
            'descendants' => 0,
            'generation' => ($life->generation + 1),
            'colour' => $faker->hexColor()
        ]);
        $self = Tag::create([
            'name' => 'Self',
            'global' => true,
            'ancestor_id' => $life->ancestor_id,
            'parent_id' => $life->id,
            'descendants' => 0,
            'generation' => ($life->generation + 1),
            'colour' => $faker->hexColor()
        ]);
        $life->increment('descendants');
            $a = Tag::create([
                'name' => 'A',
                'global' => true,
                'ancestor_id' => $self->ancestor_id,
                'parent_id' => $self->id,
                'descendants' => 0,
                'generation' => ($self->generation + 1),
                'colour' => $faker->hexColor()
            ]);
            $b = Tag::create([
                'name' => 'B',
                'global' => true,
                'ancestor_id' => $self->ancestor_id,
                'parent_id' => $self->id,
                'descendants' => 0,
                'generation' => ($self->generation + 1),
                'colour' => $faker->hexColor()
            ]);
            $c = Tag::create([
                'name' => 'C',
                'global' => true,
                'ancestor_id' => $self->ancestor_id,
                'parent_id' => $self->id,
                'descendants' => 0,
                'generation' => ($self->generation + 1),
                'colour' => $faker->hexColor()
            ]);
            $life->increment('descendants');
            $self->increment('descendants');
                $d = Tag::create([
                    'name' => 'D',
                    'global' => true,
                    'ancestor_id' => $c->ancestor_id,
                    'parent_id' => $c->id,
                    'descendants' => 0,
                    'generation' => ($c->generation + 1),
                    'colour' => $faker->hexColor()
                ]);
                $life->increment('descendants');
                $c->increment('descendants');
                    $e = Tag::create([
                        'name' => 'E',
                        'global' => true,
                        'ancestor_id' => $d->ancestor_id,
                        'parent_id' => $d->id,
                        'descendants' => 0,
                        'generation' => ($d->generation + 1),
                        'colour' => $faker->hexColor()
                    ]);
                    $life->increment('descendants');
                    $d->increment('descendants');


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
