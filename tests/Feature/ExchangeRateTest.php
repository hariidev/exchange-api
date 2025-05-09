<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ExchangeRate;


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
}
