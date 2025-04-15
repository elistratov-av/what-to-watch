<?php

namespace App\Http\Controllers;

use App\Models\Film;
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
    public function index()
    {
        return $this->success([]);
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
        return $this->success([]);
    }

    /**
     * Получение списка похожих фильмов.
     * GET /films/{filmId}/similar
     *
     * @param Film $film
     * @return Responsable
     */
    public function similar(Film $film)
    {
        return $this->success([]);
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
