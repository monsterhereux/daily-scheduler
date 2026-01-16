<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\RegisteredUserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =====================
// AUTH & DASHBOARD
// =====================
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// =====================
// PROFILE (BREEZE)
// =====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =====================
// ACTIVITIES (WEB)
// =====================
Route::middleware('auth')->group(function () {

    // list semua activities
    Route::get('/activities', [ActivityController::class, 'all'])
        ->name('activities.all');

    // list activities per tanggal
    Route::get('/activities/date/{date}', [ActivityController::class, 'byDate'])
        ->name('activities.byDate');

    // simpan activity (AJAX)
    Route::post('/activities', [ActivityController::class, 'store'])
        ->name('activities.store');

    // update activity (pakai id)
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])
        ->name('activities.update');


    // hapus activity
    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])
        ->name('activities.destroy');

    // tandai selesai
    Route::patch('/activities/{activity}/done', [ActivityController::class, 'markDone'])
        ->name('activities.done');
});

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

    


// =====================
// API ACTIVITIES (CALENDAR)
// =====================
Route::middleware('auth')->get('/api/activities', function () {
    return \App\Models\Activity::where('user_id', auth()->id())
        ->get()
        ->map(function ($activity) {
            return [
                'id'    => $activity->id,
                'title' => 'Ada aktivitas',
                'start' => $activity->start_at,
                'end'   => $activity->end_at,
            ];
        });
});

require __DIR__.'/auth.php';
