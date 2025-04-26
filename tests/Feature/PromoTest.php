<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PromoTest extends TestCase
{
    use RefreshDatabase;

    public function testGetPromoRoute()
    {
        $film1 = Film::factory()->create(['promo' => true, 'updated_at' => now()]);

        Film::factory()->create(['promo' => true, 'updated_at' => now()->subDay()]);

        $response = $this->getJson(route('promo.show'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $film1->id]);
    }

    /**
     * Проверка попытки изменения флага promo пользователем не модератором.
     * Ожидается ошибка авторизации, и не внесение изменений в БД.
     */
    public function testAddPromoByCommonUser()
    {
        Sanctum::actingAs(User::factory()->create());

        $film = Film::factory()->create(['promo' => false]);

        $response = $this->postJson(route('promo.store', $film), ['promo' => true]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('films', [
            'id' => $film->id,
            'promo' => true,
        ]);
    }

    /**
     * Установка флага promo модератором.
     */
    public function testAddPromoRoute()
    {
        Sanctum::actingAs(User::factory()->moderator()->create());

        $film = Film::factory()->create(['promo' => false]);

        $response = $this->postJson(route('promo.store', $film), ['promo' => 1]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('films', [
            'id' => $film->id,
            'promo' => true,
        ]);
    }

    /**
     * Снятие флага promo модератором.
     */
    public function testRemovePromo()
    {
        Sanctum::actingAs(User::factory()->moderator()->create());

        $film = Film::factory()->create(['promo' => true]);

        $response = $this->postJson(route('promo.store', $film), ['promo' => false]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('films', [
            'id' => $film->id,
            'promo' => false,
        ]);
    }
}
