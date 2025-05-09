<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetExchangeRateRequest;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ExchangeRate $exchangeRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExchangeRate $exchangeRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExchangeRate $exchangeRate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExchangeRate $exchangeRate)
    {
        //
    }
}
