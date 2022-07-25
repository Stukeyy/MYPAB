<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'task_id',
        'job_id',
        'date_to_send',
        'time_to_send',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the Job associated with the Reminder.
     */
    public function job()
    {
        return $this->hasOne(Job::class, 'id', 'job_id');
    }

}
