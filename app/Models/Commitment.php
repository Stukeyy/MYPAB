<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commitment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'tag_id',
        'user_id',
        'occurance',
        'day',
        'start_time',
        'end_time',
        'start_date',
        'end_date'
    ];

    // /**
    //  * Get the events related to the commitment.
    //  */
    // public function events()
    // {
    //     return $this->hasMany(Event::class);
    // }

    public function events()
    {   
        // Returned by pivot table so must be many to many - although each event will only have one commitment
        return $this->belongsToMany(Event::class, 'commitment_events')->withTimestamps();
    }

    /**
     * Get the tag related to the commitment.
     */
    public function tag()
    {
        return $this->hasOne(Tag::class, 'id', 'tag_id');
    }
    
}
