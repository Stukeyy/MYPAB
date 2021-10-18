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
        'notes',
        // checklist_idß
    ];

}
