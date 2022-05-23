<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'task',
        'tag_id',
        'user_id',
        'priority',
        'start_time',
        'end_time',
        'start_date',
        'all_day',
        'completed',
        'suggested',
        'notes'
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array
    */
    protected $casts = [
        'start_date' => 'date:Y-m-d',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'pivot'
    ];

    // convert start_date from date type to string to read in FE
    public function getStartDateAttribute($value) {
        if ($value) {
            $date = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
            return $date;
        }
    }

    // convert start_date from string type to date to store in DB
    public function setStartDateAttribute($value) {
        if ($value) {
            $this->attributes['start_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
    }

    /**
     * Get the checks that belong to the Task.
     */
    public function checks()
    {
        return $this->belongsToMany(Check::class, 'task_checks')->orderBy('id')->withTimestamps();
    }

    /**
     * Get the tag that the task belongs to.
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function priorityColour() {
        if ($this->priority === 'high') {
            return 'red';
        } else if ($this->priority === 'medium') {
            return 'yellow';
        } else {
            return 'green';
        }
    }
}
