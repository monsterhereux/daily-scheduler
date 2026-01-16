<?php

use App\Models\Activity;

Route::middleware('auth')->get('/activities', function () {
    return Activity::where('user_id', auth()->id())
        ->get()
        ->map(fn($a) => [
            'id' => $a->id,
            'title' => 'Ada aktivitas',
            'start' => $a->start_at,
            'end' => $a->end_at,
        ]);
});

