<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
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
        'commitment_id',
        'start_time',
        'end_time',
        'start_date',
        'end_date',
        'all_day',
        'isolated',
        'suggested',
        'notes'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'pivot'
    ];

    /**
     * Get the checks that belong to the Event.
     */
    public function checks()
    {
        return $this->belongsToMany(Check::class, 'event_checks')->orderBy('id')->withTimestamps();
    }

    /**
     * Get the tag that the event belongs to.
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

}
