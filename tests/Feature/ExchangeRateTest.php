<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ExchangeRate;
use App\Models\User;

class ExchangeRateTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_access_usd_rates()
    {

        for ($i = 0; $i < 7; $i++) {
            ExchangeRate::factory()->create([
                'base_currency' => 'USD',
                'target_currency' => 'LKR',
                'date' => now()->subDays($i)->format('Y-m-d'),
                'rate' => rand(10000, 30000) / 100
            ]);
        }
    
        $response = $this->getJson('/api/usd-rates');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => [
                'average_rate',
                'current_rate',
                'base_currency',
                'target_currency'
            ]
        ]);
    }

    public function test_authenticated_user_can_create_exchange_rate()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/exchange-rates', [
            'date' => '2023-01-01',
            'base_currency' => 'USD',
            'target_currency' => 'LKR',
            'rate' => 200.1234
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('exchange_rates', [
            'base_currency' => 'USD',
            'target_currency' => 'LKR',
            'rate' => 200.1234
        ]);
    }
}
