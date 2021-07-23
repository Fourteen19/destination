<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CareerReadinessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;// try to run 3 times in case of failures

//    public $backoff = 2; //wait for 2 seconds between each retry if the job fails
//    public $backoff = [2, 10, 20]; //wait for X seconds between each retry if the job fails, wait for 2 seconds after the first attempt, then 10 seconds, then 20 seconds

    public $maxExceptions = 2; //number of times a job is allowed to run if there is an error (fail with an exception)


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }


    public function failed($e)
    {
        // send an email to say it failed??
    }

}
