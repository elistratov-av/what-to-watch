<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Film;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Получение списка комментариев к фильму.
     * GET /films/{id}/comments
     *
     * @return Responsable
     */
    public function index(Film $film)
    {
        return $this->success([]);
    }

    /**
     * Добавление отзыва к фильму.
     * POST /films/{id}/comments
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Responsable
     */
    public function store(Request $request, Film $film)
    {
        return $this->success([], 201);
    }

    /**
     * Редактирование комментария.
     * PATCH /comments/{comment}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return Responsable
     */
    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('comment-update', $comment);

        return $this->success([]);
    }

    /**
     * Удаление комментария.
     * DELETE /comments/{comment}
     *
     * @param  \App\Models\Comment  $comment
     * @return Responsable
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('comment-delete', $comment);

        $comment->comments()->delete();
        $comment->delete();

        return $this->success([], 201);
    }
}
