<?php

namespace Tests\Unit;

use App\Models\Film;
use App\Support\Import\FilmsRepository;
use App\Support\Import\OmdbFilmsRepository;
use Carbon\Carbon;
use DateTimeImmutable;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OmdbFilmsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private FilmsRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new OmdbFilmsRepository(new Client());
    }

    /**
     * Проверка получения информации о фильме из репозитория.
     * Ожидается получение модели Film, массива с названиями жанров и ссылками на файлы.
     */
    public function testGetFilm()
    {
        $result = $this->repository->getFilm('tt0944947');

        $this->assertInstanceOf(Film::class, $result['film']);
        $this->assertIsArray($result['genres']);
        $this->assertIsArray($result['links']);
        $this->assertFalse($result['film']->exists);
    }

    /**
     * Проверка получения пустого ответа при запросе несуществующего фильма из репозитория.
     */
    public function testGetNotFoundShows()
    {
        $result = $this->repository->getFilm('tt0000000');

        $this->assertNull($result);
    }
}
