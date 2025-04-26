<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
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
        return $this->success(Genre::all());
    }

    /**
     * Редактирование жанра.
     * PATCH /genres/{genre}
     *
     * @param GenreRequest $request
     * @param Genre $genre
     * @return Responsable
     */
    public function update(GenreRequest $request, Genre $genre)
    {
        $genre->update($request->validated());
        return $this->success($genre->fresh());
    }
}
