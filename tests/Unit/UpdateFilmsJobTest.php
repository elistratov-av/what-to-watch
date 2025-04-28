<?php

namespace Tests\Unit;

use App\Jobs\UpdateFilm;
use App\Jobs\UpdateFilms;
use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UpdateFilmsJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверка, что задача формирует нужное к-во подзадач для обновления фильмов со статусом pending.
     * И не создает задачи для готовых фильмов.
     */
    public function testGenerateJobs()
    {
        Queue::fake();

        Film::factory(3)->pending()->create();
        $ready = Film::factory()->create(['status' => Film::STATUS_READY]);

        (new UpdateFilms())->handle();

        Queue::assertPushed(UpdateFilm::class, 3);

        Queue::assertNotPushed(function (UpdateFilm $job) use ($ready) {
            return $job->film === $ready;
        });
    }
}
