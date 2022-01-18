<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * Get the tag that the task belongs to.
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
