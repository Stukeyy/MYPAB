<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use DB;
use Log;
use Auth;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Job;
use App\Models\Reminder;

class GetJobID implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userID;
    public $task;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Int $userID, Task $task)
    {
        $this->userID = $userID;
        $this->task = $task;
        Log::info($this->task);
        Log::info($this->userID);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // I think due to dispatch time and handling executin time, we are getting duplications in reminders database
        // for now just running below logic in controller after the original reminder job is dispatched


        // Get all jobs created within last hour
        // This will include the Job created for each reminder
        // Set within last hour incase other users also submit tasks with reminders
        // This insures that task reminder jobs will be present without obtaining whole collection
        $withinLastHour = Carbon::now()->subHour()->timestamp;
        $jobs = Job::where('created_at', '>', $withinLastHour)->get();

        foreach($jobs as $job) {
            // Job data is serialized and stored as payload when Job is created
            // Need to decode and unserialize data to access
            $jobPayload = json_decode($job->payload);
            $jobData = unserialize($jobPayload->data->command);
            $jobTaskID = json_encode($jobData->task->id);
            $jobTaskID = intval($jobTaskID);

            // Task Model is attached to Job via constructor method
            // Check to see if the Jobs Task matches the current Task
            // If it does, then this is the Job ID associated with the Tasks reminder
            if ($jobTaskID === $this->task->id) {
                Reminder::create([
                    'user_id' => $this->userID,
                    'task_id' => $this->task->id,
                    'job_id' => $job->id
                ]);
            }

        }
    }
}
