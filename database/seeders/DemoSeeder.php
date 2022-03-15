<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Log;
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

        // all BASE tags
        $tags = [
            "Work",
            "Life",
            "Education",
            "Career",
            "Portfolio",
            "Skills",
            "Physical",
            "Social",
            "Self",
            "Holiday"
        ];

        // the children of each tag parent
        $tagFamily = [
            "Work" => [
                "Education",
                "Career"
            ],
            "Career" => [
                "Portfolio",
                "Skills"
            ],
            "Life" => [
                "Physical",
                "Social",
                "Self"
            ],
            "Self" => [
                "Holiday"
            ]
        ];

        // the activities of each tag parent
        $activityFamily = [
            "Physical" => [
                "Go for a run"
            ],
            "Self" => [
                "Read a book",
                "Meditate"
            ],
            "Social" => [
                "Meet up with friends"
            ],
            "Skills" => [
                "Learn a new skill"
            ]
        ];

        $users = User::all();
        // generate for each user
        foreach($users as $user) {

            // first create all base tags
            foreach($tags as $tag) {
                // colour is fully opaque
                // suggested colour is slightly translucent
                $colour = $faker->hexColor();
                $suggestedColour = $colour . '80';
                $newTag = Tag::create([
                    'name' => $tag,
                    'global' => true,
                    'colour' => $colour,
                    'suggested' => $suggestedColour
                ]);
                // also added to user pivot table
                $user->tags()->attach($newTag->id);
            }

            // adds the parent ID to each child tag created
            foreach($tagFamily as $parent => $children) {
                // gets the parent of the tag by the key
                // NOTE need to get latest tag created as same tags created for each user
                // so need ID of most recent one made as this will belong to current user
                $parentTag = Tag::where('name', $parent)->latest('id')->first();
                // adds the parent ID to each child
                foreach($children as $child) {
                    $childTag = Tag::where('name', $child)->latest('id')->first();
                    $childTag->parent_id = $parentTag->id;
                    $childTag->save();
                }
            }

            // creates activities realted to each tag
            foreach ($activityFamily as $parent => $activities) {
                // gets the parent of the tag by the key
                // NOTE need to get latest tag created as same tags created for each user
                // so need ID of most recent one made as this will belong to current user
                $parentTag = Tag::where('name', $parent)->latest('id')->first();
                // creates each activity related to the parent tag and sets it as the parent ID
                foreach($activities as $activity) {
                    $activity = Activity::create([
                        'name' => $activity,
                        'global' => true,
                        'tag_id' => $parentTag->id
                    ]);
                    // adds to user pivot table
                    $user->activities()->attach($activity->id);
                }
            }

        }


    }
}
