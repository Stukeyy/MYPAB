<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        // 'event_id',
        // 'task_id',
        'check',
        'completed'
    ];

    // /**
    //  * Get the event that the check belongs to.
    //  */
    // public function event()
    // {
    //     return $this->belongsToMany(Event::class)->withTimestamps();
    // }

    // /**
    //  * Get the task that the check belongs to.
    //  */
    // public function task()
    // {
    //     return $this->belongsToMany(Task::class)->withTimestamps();
    // }

}
