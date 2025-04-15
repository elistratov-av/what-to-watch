<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class UserController extends Controller
{
    /**
     * Получение профиля пользователя.
     * GET /user
     *
     * @return Responsable
     */
    public function show()
    {
        return $this->success([]);
    }

    /**
     * Обновление профиля пользователя.
     * PATCH /user
     *
     * @return Responsable
     */
    public function update()
    {
        return $this->success([]);
    }
}
