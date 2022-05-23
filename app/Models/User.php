<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'age',
        'gender',
        'location',
        'level',
        'institution',
        'subject',
        'employed',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Hashes user password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


    public function getFullNameAttribute() {
        return ucFirst($this->firstname) . " " . ucfirst($this->lastname);
    }

    /**
     * Get the tags that belong to the user.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'user_tags')->withTimestamps()->orderBy('id', 'ASC');
    }

    /**
     * Get all of the commitments for the user.
     */
    public function commitments()
    {
        return $this->hasMany(Commitment::class)->orderBy('start_date', 'ASC');
    }

    /**
     * Get all of the events for the user made through their commitments.
     */
    public function commitment_events()
    {
        return $this->hasManyThrough(Event::class, Commitment::class);
    }

    /**
     * Get all of the events for the user including commitments and separate events.
     */
    public function events()
    {
        // Returned by pivot table so must be many to many - although each event will only have one user
        return $this->belongsToMany(Event::class, 'user_events')->withTimestamps()->orderBy('start_date', 'ASC');
    }

    /**
     * Get all of the tasks for the user.
     */
    public function tasks()
    {
        // Returned by pivot table so must be many to many - although each task will only have one user
        return $this->belongsToMany(Task::class, 'user_tasks')->withTimestamps();
    }
    public function completed_tasks(String $orderColumn = 'start_date')
    {
        $direction = ($orderColumn === 'start_date') ? 'ASC' : 'DESC';
        return $this->belongsToMany(Task::class, 'user_tasks')->where('completed', true)->orderBy($orderColumn, $direction)->withTimestamps();
    }
    public function incomplete_tasks(String $orderColumn = 'start_date')
    {
        $direction = ($orderColumn === 'start_date') ? 'ASC' : 'DESC';
        return $this->belongsToMany(Task::class, 'user_tasks')->where('completed', false)->orderBy($orderColumn, $direction)->withTimestamps();
    }
    // returns the tasks which have been assigned a date to be displayed on the calendar
    public function dated_tasks()
    {
        return $this->belongsToMany(Task::class, 'user_tasks')->whereNotNull('start_date')->withTimestamps();
    }

    /**
     * Get the activities that belong to the user.
     */
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'user_activities')->withTimestamps()->orderBy('id', 'ASC');
    }

    /**
     * Checks if the User currently has a balancer running
     */
    public function currentlyBalancing()
    {
        return $this->hasMany(Balancer::class);
    }

    // will return an array of all dates this week
    public function week()
    {
        $now = Carbon::now();
        $weekStart = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEnd = $now->endOfWeek()->format('Y-m-d H:i');
        $period = CarbonPeriod::create($weekStart, $weekEnd);

        $dates = [];
        foreach ($period as $date) {
            $formattedDate = $date->format('d/m/Y');
            array_push($dates, $formattedDate);
        }

        return $dates;
    }

    // A separate method to get each event type between this weeks dates only - more efficient than getting all events and filtering
    // separate methods needed as because the filter is applied directly on the relationships to retrieve less, you cannot merge or concat
    // this is done in the balanceer controller instead
    public function weeklyCommitments()
    {
        $dates = $this->week();
        return $this->hasManyThrough(Event::class, Commitment::class)->whereIn("events.start_date", $dates)->whereIn("events.end_date", $dates);
    }
    public function weeklyEvents()
    {
        $dates = $this->week();
        return $this->belongsToMany(Event::class, 'user_events')->whereIn("events.start_date", $dates)->whereIn("events.end_date", $dates);
    }
    public function weeklyTasks()
    {
        $dates = $this->week();
        return $this->belongsToMany(Task::class, 'user_tasks')->whereIn("tasks.start_date", $dates);
    }

    // gets all the users tasks realted to work and orders them by priority
    public function suggestedWorkTasks()
    {
        // due to duplicate tags for each user - you need to get this specific users work tag - realtionship is used over direct query
        $workTag = $this->tags->where('name', 'Work')->first();
        // will get work tag and all children including childrens children as all realted to genesis work
        $workTagIDs = $workTag->childrenTagIDs();
        // will only return the tasks that are incomplete and related to the work tags
        return $this->belongsToMany(Task::class, 'user_tasks')->where('completed', false)->whereNull('start_date')->whereIn('tag_id', $workTagIDs)
        ->orderByRaw("case priority when 'high' then 1 when 'medium' then 2 when 'low' then 3 end");
    }
    // gets all the users activities realted to work
    public function suggestedWorkActivities()
    {
        $workTag = $this->tags->where('name', 'Work')->first();
        $workTagIDs = $workTag->childrenTagIDs();
        return $this->belongsToMany(Activity::class, 'user_activities')->whereIn('tag_id', $workTagIDs);
    }

    // gets all the users tasks realted to life and orders them by priority
    public function suggestedLifeTasks()
    {
        // due to duplicate tags for each user - you need to get this specific users life tag - realtionship is used over direct query
        $lifeTag = $this->tags->where('name', 'Life')->first();
        // will get life tag and all children including childrens children as all realted to genesis life
        $lifeTagIDs = $lifeTag->childrenTagIDs();
        // will only return the tasks that are incomplete and related to the life tags
        return $this->belongsToMany(Task::class, 'user_tasks')->where('completed', false)->whereNull('start_date')->whereIn('tag_id', $lifeTagIDs)
        ->orderByRaw("case priority when 'high' then 1 when 'medium' then 2 when 'low' then 3 end");
    }
    // gets all the users activities realted to life
    public function suggestedLifeActivities()
    {
        $lifeTag = $this->tags->where('name', 'Life')->first();
        $lifeTagIDs = $lifeTag->childrenTagIDs();
        return $this->belongsToMany(Activity::class, 'user_activities')->whereIn('tag_id', $lifeTagIDs);
    }




}
