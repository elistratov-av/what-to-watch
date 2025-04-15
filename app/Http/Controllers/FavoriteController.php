<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Получение списка фильмов добавленных пользователем в избранное.
     * GET /favorite
     *
     * @return Responsable
     */
    public function index()
    {
        return $this->success([]);
    }

    /**
     * Добавление фильма в избранное.
     * POST /films/{id}/favorite
     *
     * @param \Illuminate\Http\Request $request
     * @param Film $film
     * @return Responsable
     */
    public function store(Request $request, Film $film)
    {
        return $this->success([], 201);
    }

    /**
     * Удаление фильма из избранного.
     * DELETE /films/{id}/favorite
     *
     * @param  Film $film
     * @return Responsable
     */
    public function destroy(Film $film)
    {
        return $this->success([], 201);
    }
}
