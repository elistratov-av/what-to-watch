<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Models\Comment;
use App\Models\Film;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return $this->success($film->comments()->latest()->get());
    }

    /**
     * Добавление отзыва к фильму.
     * POST /films/{id}/comments
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Responsable
     */
    public function store(CommentStoreRequest $request, Film $film)
    {
        $comment = $film->comments()->create([
            'parent-id' => $request->comment_id,
            'text' => $request->text,
            'rating' => $request->rating,
            'user_id' => Auth::id(),
        ]);

        return $this->success($comment, 201);
    }

    /**
     * Редактирование комментария.
     * PATCH /comments/{comment}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return Responsable
     */
    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        Gate::authorize('comment-update', $comment);
        $comment->update($request->validated());

        return $this->success($comment);
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
