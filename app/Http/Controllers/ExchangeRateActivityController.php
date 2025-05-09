<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ExchangeRateActivityController extends Controller
{
    public function getStoreActivities(Request $request)
    {
        $activities = Activity::with(['causer', 'subject'])
            ->latest()
            ->paginate(15);

        return response()->json([
            'data' => $activities->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'event' => $activity->event,
                    'description' => $activity->description,
                    'causer' => $activity->causer ? $activity->causer->only('id', 'name', 'email') : null,
                    'subject' => $activity->subject ? $activity->subject->toArray() : null,
                    'properties' => $activity->properties,
                    'created_at' => $activity->created_at->toDateTimeString(),
                    'changes' => $activity->changes ?? null,
                ];
            }),
        ]);
    }
}
