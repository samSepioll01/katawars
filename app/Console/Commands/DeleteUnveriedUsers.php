<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteUnveriedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:delete-unverified';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unverified users.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $unverifies = User::where('email_verified_at', null)
            ->where('created_at', '<=', now()->subMinutes(2))
            ->get();

        if ($unverifies->count()) {

            foreach ($unverifies as $unverified) {
                $unverified->profile()->forceDelete();
                $unverified->forceDelete();
            }
        }

        return Command::SUCCESS;
    }
}
