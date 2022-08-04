<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    // date stored as YYYY-MM-DD in database as this is required to order each reminder
    // casting will format the field when it is returned from the database
    // similar to getTimeToSendAttribute accessor
    protected $casts = [
        'date_to_send' => 'datetime:d/m/Y'
    ];

    // these fields will be hidden when the model is returned from the database
    // this means that a separate resource to hide these fields will not need to be created
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // time cannot be casted, only dates
    // convert time_to_send from time to string
    public function getTimeToSendAttribute($value) {
        if ($value) {
            $time = Carbon::createFromFormat('H:i:s', $value)->format('H:i');
            return $time;
        }
    }

    /**
     * Get the Job associated with the Reminder.
     */
    public function job()
    {
        return $this->hasOne(Job::class, 'id', 'job_id');
    }

}
