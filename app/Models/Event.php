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
        'commitment_id',
        'start_time',
        'end_time',
        'start_date',
        'end_date',
        'isolated',
        'notes',
        'checklist_id',
    ];


    /**
     * Get the tag that the event belongs to.
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    /**
     * Get the Checklist that belongs to the Event.
     */
    public function checklist()
    {
        return $this->hasOne(Checklist::class, 'id', 'checklist_id');
    }

    /**
     * Get all of the checks for the event via its checklist.
     */
    public function checks()
    {
        return $this->hasManyThrough(
            Check::class,
            Checklist::class,
            'id', // Foreign key on the checklist table...
            'checklist_id', // Foreign key on the checks table...
            'checklist_id', // Local key on the event table...
            'id' // Local key on the checklist table...
        );
    }

}
