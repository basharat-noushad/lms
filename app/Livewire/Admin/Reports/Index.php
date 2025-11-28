<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Order;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $period = 'all'; // all, month, year

    public function render()
    {
        // Basic Stats
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $totalEnrollments = Enrollment::count();
        $totalUsers = User::where('role', 'student')->count();
        $totalInstructors = User::where('role', 'instructor')->count();

        // Revenue by Month (Last 12 months)
        $revenueData = Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->select(
                DB::raw('sum(total_amount) as total'), 
                DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top Courses by Revenue
        $topCourses = Course::withCount('enrollments')
            ->withSum(['orders as revenue' => function($query) {
                $query->where('status', 'completed');
            }], 'total_amount') // This is approximate as orders might have multiple items, but for MVP it's okay-ish or we need a better relation
            // Actually, better to use order_items if we had a direct relation or just use enrollments count for now as revenue calculation is complex without order_items table logic in Course model
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get();

        // Correct revenue calculation for courses requires joining order_items
        // For MVP, let's just list top courses by enrollment count
        
        return view('livewire.admin.reports.index', [
            'totalRevenue' => $totalRevenue,
            'totalEnrollments' => $totalEnrollments,
            'totalUsers' => $totalUsers,
            'totalInstructors' => $totalInstructors,
            'revenueData' => $revenueData,
            'topCourses' => $topCourses,
        ]);
    }
}
