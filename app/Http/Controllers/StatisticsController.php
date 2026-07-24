<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Transaction;
use App\Models\TimeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        // Monthly income/expense for last 6 months
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->translatedFormat('M Y'),
                'income' => Transaction::where('type', 'income')
                    ->whereYear('transaction_date', $date->year)
                    ->whereMonth('transaction_date', $date->month)
                    ->sum('amount'),
                'expense' => Transaction::where('type', 'expense')
                    ->whereYear('transaction_date', $date->year)
                    ->whereMonth('transaction_date', $date->month)
                    ->sum('amount'),
            ];
        }

        // Project status breakdown
        $projectStats = [
            'todo' => Project::where('status', 'todo')->count(),
            'in_progress' => Project::where('status', 'in_progress')->count(),
            'done' => Project::where('status', 'done')->count(),
        ];

        // Project type breakdown
        $projectTypes = [
            'joki' => Project::where('type', 'joki')->count(),
            'aplikasi' => Project::where('type', 'aplikasi')->count(),
        ];

        // Total hours worked
        $totalMinutes = TimeLog::whereNotNull('duration_minutes')->sum('duration_minutes');

        // Total income & expense
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');

        // Top projects by income
        $topProjects = Project::withSum(['transactions as total_income' => function($q) {
            $q->where('type', 'income');
        }], 'amount')
        ->orderByDesc('total_income')
        ->take(5)
        ->get();

        return view('statistics.index', compact(
            'monthlyData', 'projectStats', 'projectTypes',
            'totalMinutes', 'totalIncome', 'totalExpense', 'topProjects'
        ));
    }
}
