<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'global',
        'ancestor_id',
        'parent_id',
        'descendants',
        'generation',
        'colour'
    ];

    // Hides pivot property in response for user() relationship
    protected $hidden = ['pivot'];

    // Gets the original parent of the tag, will only ever be Work or Life
    public function genesis()
    {
        $tag = $this;
        $hasAncestors = true;
        while ($hasAncestors) {
            // If the tag has a parent ID then continue loop until Work or Life which wont
            // This will loop through Tag parents until Work or Life
            if ($tag->parent_id) {
                $parent = Tag::find($tag->parent_id);
                $tag = $parent;
            }
            else {
                $hasAncestors = false;
                return $tag;
            }
        }
    }

    /**
     * Get all ancestors of the tag.
     */
    public function ancestors()
    {
        $ancestors = [];

        $tag = $this;
        $hasAncestors = true;
        while ($hasAncestors) {
            // If the tag has a parent ID - push to ancestors array and set as new current tag
            // This will loop through Tag parents until Work or Life - shown as ancestors in view tag page
            if ($tag->parent_id) {
                $parent = Tag::find($tag->parent_id);
                array_push($ancestors, $parent);
                $tag = $parent;
            }
            else {
                $hasAncestors = false;
            }
        }
        return array_reverse($ancestors);
    }

    /**
     * Get the parent of the tag.
     */
    public function parent()
    {
        // run check to make sure not work or life as these have no parent?
        return $this->belongsTo(Tag::class);
    }

    /**
     * Get the children of the tag - DESCENDANTS - returns children with their own children
     */
    public function children()
    {
        return $this->hasMany(Tag::class, 'parent_id', 'id')->with('children');
    }

    // will return only an array of the children tag ids including work or life tag id
    public function childrenTagIDs() {

        $tagIDs = [];
        array_push($tagIDs, $this->id);
        // will get tag and children including childrens children as all descendants of the genesis tag
        $descendantTags = $this->children;

        // will add all tag child IDs and child children IDs to an array avoiding duplicates
        foreach ($descendantTags as $tag) {
            if (!in_array($tag->id, $tagIDs)) {
                array_push($tagIDs, $tag->id);
            }
            if ($tag->children) {
                foreach ($tag->children as $child) {
                    if (!in_array($child->id, $tagIDs)) {
                        array_push($tagIDs, $child->id);
                    }
                }
            }
        }
        return $tagIDs;
    }

    /**
     * Get the user that the tag belongs to.
     */
    public function user()
    {
        // Returned by pivot table so must be many to many - will only return 1 user for each
        return $this->belongsToMany(User::class, 'user_tags')->withTimestamps();
    }

    /**
     * Get the events related to the tag.
     */
    public function events()
    {
        // Need to be limited to individual user before calling
        return $this->hasMany(Event::class);
    }

    /**
     * Get the tasks related to the tag.
     */
    public function tasks()
    {
        // Need to be limited to individual user before calling
        return $this->hasMany(Task::class);
    }

    /**
     * Get the activities related to the tag.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

}
