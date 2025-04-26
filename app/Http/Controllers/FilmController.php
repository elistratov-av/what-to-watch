<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Services\FilmService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Получение списка фильмов.
     * GET /films
     *
     * @return Responsable
     */
    public function index(Request $request)
    {
        $films = Film::select(Film::LIST_FIELDS)
            ->when($request->has('genre'), function ($query) use ($request) {
                $query->whereRelation('genres', 'name', $request->get('genre'));
            })
            ->when($request->has('status') && $request->user()?->isModerator(),
                function ($query) use ($request) {
                    $query->whereStatus($request->get('status'));
                },
                function ($query) {
                    $query->whereStatus(Film::STATUS_READY);
                }
            )
            ->ordered($request->get('order_by'), $request->get('order_to'))
            ->paginate(8);

        return $this->paginate($films);
    }

    /**
     * Получение информации о фильме.
     * GET /films/{filmId}
     *
     * @param Film $film
     * @return Responsable
     */
    public function show(Film $film)
    {
        return $this->success($film->append(['rating', 'is_favorite'])->loadCount('scores'));
    }

    /**
     * Получение списка похожих фильмов.
     * GET /films/{filmId}/similar
     *
     * @param Film $film
     * @return Responsable
     */
    public function similar(Film $film, FilmService $service)
    {
        return $this->success($service->getSimilarFor($film, Film::LIST_FIELDS));
    }

    /**
     * Добавление фильма в базу.
     * POST /films
     *
     * @param Request $request
     * @return Responsable
     */
    public function store(Request $request)
    {
        return $this->success([], 201);
    }

    /**
     * Редактирование фильма.
     * PUT /films
     *
     * @param Request $request
     * @param Film  $film
     * @return Responsable
     */
    public function update(Request $request, Film $film)
    {
        return $this->success([]);
    }
}
