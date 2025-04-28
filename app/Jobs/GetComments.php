<?php

namespace App\Jobs;

use App\Models\Film;
use App\Support\Import\CommentsRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetComments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Film $film)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(CommentsRepository $repository): void
    {
        $comments = $repository->getComments($this->film->imdb_id);
        $this->film->comments()->saveMany($comments ?? []);
    }
}
