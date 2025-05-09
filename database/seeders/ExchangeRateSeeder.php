<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExchangeRate;
use Carbon\Carbon;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = ['LKR', 'CAD', 'GBP', 'AUD'];
        $baseCurrency = 'USD';

        $startDate = Carbon::now()->subDays(90);
        
        for ($i = 0; $i < 90; $i++) {
            $date = $startDate->copy()->addDays($i);
            
            foreach ($currencies as $currency) {
                ExchangeRate::create([
                    'date' => $date,
                    'base_currency' => $baseCurrency,
                    'target_currency' => $currency,
                    'rate' => rand(10000, 30000) / 100
                ]);
            }
        }
    }
}
