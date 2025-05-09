<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetExchangeRateRequest;
use App\Http\Requests\StoreExchangeRateRequest;
use App\Models\ExchangeRate;

class ExchangeRateController extends Controller
{
    /**
     * Display a listing of the Exchange Rates.
     */
    public function index(GetExchangeRateRequest $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));
        $baseCurrency = $request->input('base_currency', 'USD');
        $targetCurrency = $request->input('target_currency', 'LKR');

        $rates = ExchangeRate::where('base_currency', $baseCurrency)
            ->where('target_currency', $targetCurrency)
            ->whereDate('date', '<=', $date)
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        if ($rates->isEmpty()) {
            return response()->json([
                'message' => 'No exchange rates found'
            ], 404);
        }

        // Calculate average
        $average = $rates->avg('rate');

        return response()->json([
            'data' => $rates,
            'meta' => [
                'average_rate' => number_format($average, 4),
                'current_rate' => number_format($rates->first()->rate, 4),
                'base_currency' => $baseCurrency,
                'target_currency' => $targetCurrency
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExchangeRateRequest $request)
    {
        $activity = activity()
            ->causedBy($request->user()) 
            ->withProperties([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'input_data' => $request->safe()->except(['password', 'token'])
            ]);

        try {

            $existingRate = ExchangeRate::where([
                'date' => $request->date,
                'base_currency' => $request->base_currency,
                'target_currency' => $request->target_currency
            ])->first();

            $rate = ExchangeRate::updateOrCreate(
                [
                    'date' => $request->date,
                    'base_currency' => $request->base_currency,
                    'target_currency' => $request->target_currency
                ],
                ['rate' => $request->rate]
            );

            $eventType = $existingRate ? 'updated' : 'created';

            $activity->performedOn($rate)
                ->withProperties([
                    'previous_rate' => $existingRate ? $existingRate->rate : null,
                    'new_rate' => $rate->rate,
                    'changes' => $existingRate ? $rate->getChanges() : $rate->toArray()
                ])
                ->log("exchange_rate_{$eventType}");

            return response()->json([
                'message' => 'Exchange rate saved successfully',
                'data' => $rate,
            ], 201);

        } catch (\Exception $e) {

            $activity->withProperties([
                    'error' => $e->getMessage(),
                    'error_trace' => config('app.debug') ? $e->getTraceAsString() : null
                ])
                ->log('exchange_rate_save_failed');

            return response()->json([
                'message' => 'Failed to save exchange rate',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred'
            ], 500);
        }
    }
}
