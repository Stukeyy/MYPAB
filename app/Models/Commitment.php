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

    /**
     * Get the events related to the commitment.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    
}
