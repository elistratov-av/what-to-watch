<?php

namespace App\Jobs;

use App\Support\Import\CommentsRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchLastComments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(CommentsRepository $repository): void
    {
        $comments = $repository->getLatest(Carbon::yesterday()->toDateString());
        if (!$comments) return;

        foreach ($comments as $comment) {
            $comment->save();
        }
    }
}
