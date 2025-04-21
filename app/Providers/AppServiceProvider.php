<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        // Удалять комментарии может только модератор или автор комментария если на него нет ответов
        Gate::define('comment-delete', function ($user, $comment) {
            if ($user->role_id == User::ROLE_MODERATOR) {
                return true;
            }
            return $user->id === $comment->user_id && $comment->comments->isEmpty();
        });

        // Редактировать комментарии может только модератор или автор комментария
        Gate::define('comment-update', function ($user, $comment) {
            return $user->role_id == User::ROLE_MODERATOR || $user->id === $comment->user_id;
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
