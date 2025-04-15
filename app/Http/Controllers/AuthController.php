<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class AuthController extends Controller
{
    /**
     * Регистрация пользователя.
     * POST /register
     *
     * @return Responsable
     */
    public function register()
    {
        return $this->success([], 201);
    }

    /**
     * Авторизация и создания токена аутентификации.
     * POST /login
     *
     * @return Responsable
     */
    public function login()
    {
        return $this->success([]);
    }

    /**
     * Удаление токена аутентификации.
     * DELETE /logout
     *
     * @return Responsable
     */
    public function logout()
    {
        return $this->success([], 204);
    }
}
