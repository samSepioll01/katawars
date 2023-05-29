<?php

namespace App\Jobs;

use App\Mail\NewFollower;
use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ReportNewFollower implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $follower;
    public $followee;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Profile $follower, Profile $followee)
    {
        $this->follower = $follower;
        $this->followee = $followee;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new NewFollower($this->follower, $this->followee));
    }
}
