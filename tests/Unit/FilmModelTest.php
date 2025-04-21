<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверка вычисления значения rating, пользовательской оценки фильма.
     * Ожидается среднее значение округленное по правилам математики.
     */
    public function testGetRating()
    {
        Film::factory()
            ->has(Comment::factory(3)->sequence(['rating' => 1], ['rating' => 2], ['rating' => 1]))
            ->create();

        $this->assertEquals(1.3, Film::first()->rating); // 4/3 = 1.3333(3)
    }
}
