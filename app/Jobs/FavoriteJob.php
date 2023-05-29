<?php

namespace App\Jobs;

use App\Mail\AddFavorite;
use App\Models\Favorite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class FavoriteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $favorite;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($favorite)
    {
        $this->favorite = $favorite;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new AddFavorite($this->favorite));
    }
}
