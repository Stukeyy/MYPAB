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
     * Get the ancestor of the tag (Work or Life).
     */
    public function ancestor()
    {
        return $this->hasOne(Tag::class, 'id', 'ancestor_id');
    }

    /**
     * Get the parent of the tag.
     */
    public function parent()
    {
        return $this->hasOne(Tag::class, 'id', 'parent_id');
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
        return $this->belongsToMany(User::class, 'user_tags');
    }

    /**
     * Get the activities related to the tag.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

}
