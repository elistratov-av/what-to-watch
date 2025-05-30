<?php

namespace Tests\Unit;

use App\Jobs\FetchLastComments;
use App\Models\Comment;
use App\Models\Film;
use App\Support\Import\CommentsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class FetchLastCommentsJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверка добавления комментариев
     */
    public function testSaveComments()
    {
        $film1 = Film::factory()->create();
        $film2 = Film::factory()->create();

        $comments = collect([
            Comment::factory()->external()->make(['film_id' => $film1->id]),
            Comment::factory()->external()->make(['film_id' => $film2->id]),
        ]);

        $repository = $this->mock(CommentsRepository::class, function (MockInterface $mock) use ($comments) {
            $mock->shouldReceive('getLatest')->andReturn($comments)->once();
        });

        (new FetchLastComments())->handle($repository);

        $this->assertDatabaseCount(Comment::class, 2);
        $this->assertDatabaseHas('comments', [
            'text' => $comments->first()->text,
            'film_id' => $film1->id,
            'user_id' => null,
        ]);
    }
}
