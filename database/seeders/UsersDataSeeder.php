<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = User::factory()->make();

        /** @var User $user */
        $user = User::updateOrCreate(
            ['email' => 'demo@laravel.localhost'],
            [
                'email' => 'demo@laravel.localhost',
                'password' => '12345678',
                'name' => $data->name,
            ]
        );

        $user->films()->sync(Film::inRandomOrder()->limit(3)->pluck('id'));
        $user->comments()->saveMany(Comment::factory()->count(2)->make());
        $user->comments()->save(Comment::factory()->unrated()->make());

        $sourceComment = Comment::inRandomOrder()->first();
        $user->comments()->save(Comment::factory()->unrated()->make(['film_id' => $sourceComment->film_id,'parent_id' => $sourceComment->id]));

        User::updateOrCreate(
            ['email' => 'moderator@laravel.localhost'],
            [
                'email' => 'moderator@laravel.localhost',
                'password' => '12345678',
                'name' => 'moderator',
                'role_id' => User::ROLE_MODERATOR,
            ]
        );
    }
}
