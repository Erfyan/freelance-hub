<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ClientController,
    ProjectController,
    TransactionController,
    ProjectFileController,
    TimerController,
    WebAuthnController,
    ProfileController,
    StatisticsController
};

// Public Guest Dashboard (Portofolio & Status Proyek Publik)
Route::get('/', function (\Illuminate\Http\Request $request) {
    // Hanya tampilkan proyek Klien yang sedang dalam progres atau tertunda (Proyek Personal DIKECUALIKAN)
    $query = \App\Models\Project::with('client')
        ->where('category', 'client')
        ->whereIn('status', ['in_progress', 'on_hold']);

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }
    if ($request->filled('status') && in_array($request->status, ['in_progress', 'on_hold'])) {
        $query->where('status', $request->status);
    }
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $projects = $query->latest()->paginate(12);

    $totalDone = \App\Models\Project::where('status', 'done')->count();
    $totalInProgress = \App\Models\Project::where('status', 'in_progress')->count();
    $totalClients = \App\Models\Client::count();

    return view('public.index', compact('projects', 'totalDone', 'totalInProgress', 'totalClients'));
})->name('public.index');

// WebAuthn routes (bisa diakses tanpa login untuk discovery)
Route::get('/webauthn/login-page', [WebAuthnController::class, 'showLoginForm'])->name('webauthn.login.page');
Route::post('/webauthn/discover-user', [WebAuthnController::class, 'discoverUser'])->name('webauthn.discover.user');
Route::get('/webauthn/auth/{user_id}', [WebAuthnController::class, 'showAuthForm'])->name('webauthn.show.form');

// Routes yang butuh authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $activeProjects = \App\Models\Project::where('status', '!=', 'done')->count();
        $monthlyIncome = \App\Models\Transaction::where('type', 'income')
            ->whereMonth('transaction_date', now()->month)
            ->sum('amount');
        $todayMinutes = \App\Models\TimeLog::whereDate('start_time', today())
            ->whereNotNull('duration_minutes')
            ->sum('duration_minutes') ?? 0;
        $recentProjects = \App\Models\Project::with('client')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('activeProjects', 'monthlyIncome', 'todayMinutes', 'recentProjects'));
    })->name('dashboard');

    // Clients
    Route::resource('clients', ClientController::class);

    // Projects
    Route::resource('projects', ProjectController::class);

    // Transactions related to a project
    Route::post('projects/{project}/transactions', [TransactionController::class, 'store'])->name('projects.transactions.store');
    Route::delete('transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    // Files related to a project
    Route::post('projects/{project}/files', [ProjectFileController::class, 'store'])->name('projects.files.store');
    Route::delete('files/{file}', [ProjectFileController::class, 'destroy'])->name('files.destroy');

    // Timer
    Route::get('timer', [TimerController::class, 'index'])->name('timer.index');
    Route::post('projects/{project}/timer/start', [TimerController::class, 'start'])->name('timer.start');
    Route::post('timer/stop', [TimerController::class, 'stop'])->name('timer.stop');
    Route::get('timer/status', [TimerController::class, 'status'])->name('timer.status');

    // Statistics
    Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Passkey Management (halaman setup & register)
    Route::get('/webauthn/register', [WebAuthnController::class, 'showRegisterPage'])->name('webauthn.register.page');
    Route::post('/webauthn/register', [WebAuthnController::class, 'register'])->name('webauthn.register');
    Route::delete('/webauthn/credential', [WebAuthnController::class, 'deleteCredential'])->name('webauthn.delete');
});

// Auth routes dari Breeze (login, register, dll)
require __DIR__.'/auth.php';

// Endpoint WebAuthn dari package Laragear
\Laragear\WebAuthn\Http\Routes::routes();