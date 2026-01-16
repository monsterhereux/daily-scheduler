<?php
namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * ============================
     * HALAMAN SEMUA AKTIVITAS
     * ============================
     */
    public function all()
    {
        $activities = Activity::where('user_id', auth()->id())
            ->orderBy('start_at')
            ->get();

        return view('activities.index', compact('activities'));
    }

    /**
     * ============================
     * SIMPAN AKTIVITAS (AJAX)
     * ============================
     */
public function store(Request $request)
{
    Activity::create([
        'user_id' => auth()->id(),
        'title' => $request->title,
        'priority' => $request->priority,
        'description' => $request->description,
        'start_at' => $request->start,
        'end_at' => $request->end,
        'is_done' => false,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Aktivitas berhasil disimpan'
    ]);

        // CEK KONFLIK JADWAL
        $conflict = Activity::where('user_id', auth()->id())
            ->where(function ($q) use ($data) {
                $q->whereBetween('start_at', [$data['start'], $data['end']])
                  ->orWhereBetween('end_at', [$data['start'], $data['end']])
                  ->orWhere(function ($q2) use ($data) {
                      $q2->where('start_at', '<=', $data['start'])
                         ->where('end_at', '>=', $data['end']);
                  });
            })->exists();

        if ($conflict) {
            return response()->json([
                'message' => 'Jadwal bentrok dengan aktivitas lain'
            ], 422);
        }

        // SIMPAN AKTIVITAS
        Activity::create([
            'user_id'     => auth()->id(),
            'title'       => $data['title'],
            'priority'    => $data['priority'],
            'description' => $data['description'],
            'start_at'    => $data['start'],
            'end_at'      => $data['end'],
            'is_done'     => false,
        ]);

        // FLASH MESSAGE (UNTUK HALAMAN /activities)
        session()->flash('success', 'Aktivitas berhasil disimpan');

        // BALAS JSON (UNTUK AXIOS)
        return response()->json([
            'success'  => true,
            'redirect' => route('activities.all'),
        ]);
    }

    /**
     * ============================
     * AKTIVITAS PER TANGGAL
     * ============================
     */
    public function byDate($date)
    {
        $activities = Activity::where('user_id', auth()->id())
            ->whereDate('start_at', $date)
            ->orderBy('start_at')
            ->get();

        return view('activities.index', [
            'activities' => $activities,
            'date'       => $date
        ]);
    }

public function edit(Activity $activity)
{
    if ($activity->user_id !== auth()->id()) {
        abort(403);
    }

    return view('activities.edit', compact('activity'));
}

public function update(Request $request, Activity $activity)
{
    if ($activity->user_id !== auth()->id()) {
        abort(403);
    }

    $activity->update([
        'title'       => $request->title,
        'priority'    => $request->priority,
        'description' => $request->description,
        'start_at'    => $request->start_at,
        'end_at'      => $request->end_at,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Aktivitas berhasil diperbarui'
    ]);
}
    
   public function destroy(Activity $activity)
{
    if ($activity->user_id !== auth()->id()) {
        abort(403);
    }

    $activity->delete();

    return back()->with('success', 'Aktivitas berhasil dihapus');
}


    /**
     * ============================
     * TOGGLE SELESAI / BELUM
     * ============================
     */
    public function toggle($id)
    {
        $activity = Activity::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $activity->is_done = ! $activity->is_done;
        $activity->save();

        return back();
    }

    /**
     * ============================
     * TANDAI SELESAI (AMAN)
     * ============================
     */
    public function markDone(Activity $activity)
    {
        if ($activity->user_id !== auth()->id()) {
            abort(403);
        }

        $activity->update([
            'is_done' => true
        ]);

        return back();
    }
}
