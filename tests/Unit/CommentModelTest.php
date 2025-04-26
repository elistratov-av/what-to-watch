<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверка подстановки имени автора комментария.
     * В зависимости от наличия указания на автора или нет (для импортированных комментариев).
     */
    public function testAuthorName()
    {
        $databaseName = DB::connection()->getDatabaseName();
        $user = User::factory()->create();
        $userComment = Comment::factory()->for($user)->create();
        $guestComment = Comment::factory()->create(['user_id' => null]);

        $this->assertEquals($user->name, $userComment->author);
        $this->assertEquals(Comment::DEFAULT_AUTHOR, $guestComment->author);
    }
}
