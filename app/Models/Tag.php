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

    /**
     * Get the parent of the tag.
     */
    public function parent()
    {   
        // run check to make sure not work or life as these have no parent?
        return $this->belongsTo(Tag::class);
    }

    /**
     * Get the ancestors of the tag.
     */
    public function ancestors(Tag $tag)
    {       
        $ancestors = [];

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
     * Get the children of the tag.
     */
    public function children()
    {
        return $this->hasMany(Tag::class, 'parent_id', 'id');
    }

    /**
     * Get the user that the tag belongs to.
     */
    public function user()
    {   
        // Returned by pivot table so must be many to many - will only return 1 user for each
        return $this->belongsToMany(User::class, 'user_tags')->withTimestamps();;
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
     * Get the activities related to the tag.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

}
