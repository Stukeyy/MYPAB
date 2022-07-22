<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Log;

use App\Models\Task;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $task;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
        Log::info($this->task);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // NEED TO RESTART QUEUE AFTER ANY JOB CHANGES
        Mail::to("stephenr.ross@yahoo.com")->send(new TestMail($this->task));
    }
}
