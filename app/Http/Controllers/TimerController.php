<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimerController extends Controller
{
    // Halaman list/manage timer
    public function index()
    {
        $runningLog = TimeLog::where('is_running', true)->with('project')->first();
        
        // Riwayat time logs hari ini
        $todayLogs = TimeLog::whereDate('start_time', today())
            ->where('is_running', false)
            ->with('project')
            ->latest()
            ->get();
            
        // Daftar proyek aktif untuk dipilih
        $projects = Project::where('status', '!=', 'done')->orderBy('title')->get();
        
        return view('timer.index', compact('runningLog', 'todayLogs', 'projects'));
    }

    // Mulai timer untuk proyek
    public function start(Request $request, Project $project)
    {
        // Cek apakah sudah ada timer berjalan di database
        $activeTimer = TimeLog::where('is_running', true)->first();
        if ($activeTimer) {
            $msg = 'Timer sudah berjalan di proyek: ' . ($activeTimer->project->title ?? 'Lain');
            if ($request->expectsJson()) {
                return response()->json(['message' => $msg], 409);
            }
            return redirect()->back()->with('error', $msg);
        }

        $timeLog = TimeLog::create([
            'project_id' => $project->id,
            'start_time' => now(),
            'end_time' => null,
            'is_running' => true,
            'note' => $request->input('note'),
        ]);

        session([
            'timer_running_project_id' => $project->id,
            'timer_start_time' => now()->toDateTimeString(),
            'timer_time_log_id' => $timeLog->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Timer dimulai',
                'time_log_id' => $timeLog->id,
                'start_time' => now()->toDateTimeString(),
            ]);
        }

        return redirect()->back()->with('success', 'Timer dimulai!');
    }

    // Hentikan timer
    public function stop(Request $request)
    {
        // Temukan timer yang sedang berjalan di DB
        $timeLog = TimeLog::where('is_running', true)->first();
        
        if (!$timeLog) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Tidak ada timer berjalan.'], 404);
            }
            return redirect()->back()->with('error', 'Tidak ada timer berjalan.');
        }

        $endTime = now();
        // Hitung selisih dalam detik, lalu konversi ke menit dengan pembulatan ke atas. Minimal 1 menit.
        $durationSeconds = Carbon::parse($timeLog->start_time)->diffInSeconds($endTime);
        $duration = max(1, (int) ceil($durationSeconds / 60));

        $timeLog->update([
            'end_time' => $endTime,
            'duration_minutes' => $duration,
            'is_running' => false,
            'note' => $request->input('note') ?? $timeLog->note,
        ]);

        session()->forget(['timer_running_project_id', 'timer_start_time', 'timer_time_log_id']);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Timer dihentikan',
                'duration_minutes' => $duration,
            ]);
        }

        return redirect()->back()->with('success', 'Timer dihentikan! Durasi: ' . $duration . ' menit.');
    }

    // Ambil status timer saat ini (untuk global indicator)
    public function status()
    {
        $activeTimer = TimeLog::where('is_running', true)->with('project:id,title')->first();
        
        if (!$activeTimer) {
            return response()->json(['active' => false]);
        }

        return response()->json([
            'active' => true,
            'project' => $activeTimer->project,
            'start_time' => $activeTimer->start_time->toDateTimeString(),
        ]);
    }
}
