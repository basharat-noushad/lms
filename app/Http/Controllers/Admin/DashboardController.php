<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Course, Order, Enrollment};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            // User Statistics
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_instructors' => User::where('role', 'instructor')->count(),
            'total_students' => User::where('role', 'student')->count(),
            'recent_users' => User::latest()->take(5)->get(),

            // Course Statistics
            'total_courses' => Course::count(),
            'published_courses' => Course::where('is_published', true)->count(),
            'pending_courses' => Course::where('status', 'pending')->count(),
            'draft_courses' => Course::where('status', 'draft')->count(),
            'recent_courses' => Course::with('instructor')->latest()->take(5)->get(),

            // Revenue Statistics
            'total_revenue' => Order::where('payment_status', 'completed')->sum('total_amount'),
            'monthly_revenue' => Order::where('payment_status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_amount'),
            'recent_orders' => Order::with('user')->latest()->take(10)->get(),

            // Enrollment Statistics
            'total_enrollments' => Enrollment::count(),
            'monthly_enrollments' => Enrollment::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),

            // Charts data
            'revenue_chart' => $this->getRevenueChartData(),
            'enrollment_chart' => $this->getEnrollmentChartData(),
        ];

        return view('admin.dashboard', $stats);
    }

    private function getRevenueChartData()
    {
        $months = [];
        $revenue = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            $revenue[] = Order::where('payment_status', 'completed')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');
        }

        return [
            'labels' => $months,
            'data' => $revenue,
        ];
    }

    private function getEnrollmentChartData()
    {
        $months = [];
        $enrollments = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            $enrollments[] = Enrollment::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        return [
            'labels' => $months,
            'data' => $enrollments,
        ];
    }
}
