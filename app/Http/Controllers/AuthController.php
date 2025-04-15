<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Регистрация пользователя.
     * POST /register
     *
     * @return Responsable
     */
    public function register(UserRequest $request)
    {
        $params = $request->safe()->except('file');
        $user = User::create($params);
        $token = $user->createToken('auth-token');

        return $this->success([
            'user' => $user,
            'token' => $token->plainTextToken,
        ], 201);
    }

    /**
     * Авторизация и создания токена аутентификации.
     * POST /login
     *
     * @return Responsable
     */
    public function login(LoginRequest $request)
    {
        if(!Auth::attempt($request->validated())) {
            abort(401, trans('auth.failed'));
        }

        $token = Auth::user()->createToken('auth-token');

        return $this->success(['token' => $token->plainTextToken]);
    }

    /**
     * Удаление токена аутентификации.
     * DELETE /logout
     *
     * @return Responsable
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return $this->success(null, 204);
    }
}
