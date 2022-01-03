<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
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
        'tag_id'
    ];

    // Hides pivot property in response for user() relationship
    protected $hidden = ['pivot'];

    /**
     * Get the user that the activity belongs to.
     */
    public function user()
    {   
        // Returned by pivot table so must be many to many - will only return 1 user for each
        return $this->belongsToMany(User::class, 'user_activities');
    }

    /**
     * Get the tag the activity belongs to.
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

}
