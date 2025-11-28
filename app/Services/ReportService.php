<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportService
{
    public function getRevenueData($period = 'month')
    {
        $query = Order::where('status', 'completed');
        
        if ($period === 'year') {
            $data = $query->whereYear('created_at', Carbon::now()->year)
                ->select(
                    DB::raw('MONTH(created_at) as label'),
                    DB::raw('SUM(amount) as value')
                )
                ->groupBy('label')
                ->orderBy('label')
                ->get();
                
            return $this->formatData($data, 'month');
        } else {
            // Default to last 30 days
            $data = $query->where('created_at', '>=', Carbon::now()->subDays(30))
                ->select(
                    DB::raw('DATE(created_at) as label'),
                    DB::raw('SUM(amount) as value')
                )
                ->groupBy('label')
                ->orderBy('label')
                ->get();
                
            return $this->formatData($data, 'day');
        }
    }

    public function getEnrollmentData($period = 'month')
    {
        $query = Enrollment::query();

        if ($period === 'year') {
            $data = $query->whereYear('created_at', Carbon::now()->year)
                ->select(
                    DB::raw('MONTH(created_at) as label'),
                    DB::raw('COUNT(*) as value')
                )
                ->groupBy('label')
                ->orderBy('label')
                ->get();

            return $this->formatData($data, 'month');
        } else {
            $data = $query->where('created_at', '>=', Carbon::now()->subDays(30))
                ->select(
                    DB::raw('DATE(created_at) as label'),
                    DB::raw('COUNT(*) as value')
                )
                ->groupBy('label')
                ->orderBy('label')
                ->get();

            return $this->formatData($data, 'day');
        }
    }

    public function getUserGrowthData($period = 'month')
    {
        $query = User::where('role', 'student');

        if ($period === 'year') {
            $data = $query->whereYear('created_at', Carbon::now()->year)
                ->select(
                    DB::raw('MONTH(created_at) as label'),
                    DB::raw('COUNT(*) as value')
                )
                ->groupBy('label')
                ->orderBy('label')
                ->get();

            return $this->formatData($data, 'month');
        } else {
            $data = $query->where('created_at', '>=', Carbon::now()->subDays(30))
                ->select(
                    DB::raw('DATE(created_at) as label'),
                    DB::raw('COUNT(*) as value')
                )
                ->groupBy('label')
                ->orderBy('label')
                ->get();

            return $this->formatData($data, 'day');
        }
    }

    public function getKeyMetrics()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // Revenue
        $currentMonthRevenue = Order::where('status', 'completed')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('amount');
            
        $lastMonthRevenue = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('amount');

        // Enrollments
        $currentMonthEnrollments = Enrollment::where('created_at', '>=', $startOfMonth)->count();
        $lastMonthEnrollments = Enrollment::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        // Active Students
        $totalStudents = User::where('role', 'student')->count();
        $newStudents = User::where('role', 'student')
            ->where('created_at', '>=', $startOfMonth)
            ->count();

        return [
            'revenue' => [
                'value' => $currentMonthRevenue,
                'growth' => $this->calculateGrowth($currentMonthRevenue, $lastMonthRevenue)
            ],
            'enrollments' => [
                'value' => $currentMonthEnrollments,
                'growth' => $this->calculateGrowth($currentMonthEnrollments, $lastMonthEnrollments)
            ],
            'students' => [
                'total' => $totalStudents,
                'new' => $newStudents
            ]
        ];
    }

    private function calculateGrowth($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return (($current - $previous) / $previous) * 100;
    }

    private function formatData($data, $type)
    {
        $formatted = [];
        $labels = [];
        $values = [];

        if ($type === 'month') {
            for ($i = 1; $i <= 12; $i++) {
                $labels[] = Carbon::create()->month($i)->format('M');
                $record = $data->firstWhere('label', $i);
                $values[] = $record ? $record->value : 0;
            }
        } else {
            // Last 30 days
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $labels[] = $date->format('M d');
                $record = $data->firstWhere('label', $date->format('Y-m-d'));
                $values[] = $record ? $record->value : 0;
            }
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
}
