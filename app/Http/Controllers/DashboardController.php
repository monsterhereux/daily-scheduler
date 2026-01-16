<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $userId = auth()->id();

    return view('dashboard', [
        'today' => Activity::whereDate('start_at', now())->where('user_id',$userId)->count(),
        'pending' => Activity::where('is_done', false)->where('user_id',$userId)->count(),
        'done' => Activity::where('is_done', true)->where('user_id',$userId)->count(),
        'upcoming' => Activity::whereDate('start_at','>', now())->where('user_id',$userId)->count(),
    ]);
}

}
