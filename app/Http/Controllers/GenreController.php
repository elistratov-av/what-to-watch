<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Получение списка жанров.
     * GET /genres
     *
     * @return Responsable
     */
    public function index()
    {
        return $this->success([]);
    }

    /**
     * Редактирование жанра.
     * PATCH /genres/{genre}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genre  $genre
     * @return Responsable
     */
    public function update(Request $request, Genre $genre)
    {
        return $this->success([]);
    }
}
