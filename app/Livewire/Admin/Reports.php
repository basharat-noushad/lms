<?php

namespace App\Livewire\Admin;

use App\Services\ReportService;
use Livewire\Component;
use Livewire\Attributes\Url;

class Reports extends Component
{
    public $period = 'month'; // 'month' (last 30 days) or 'year' (current year)
    
    public $revenueData;
    public $enrollmentData;
    public $userGrowthData;
    public $metrics;

    public function mount(ReportService $reportService)
    {
        $this->loadData($reportService);
    }

    public function updatedPeriod()
    {
        $this->loadData(app(ReportService::class));
        $this->dispatch('update-charts', [
            'revenue' => $this->revenueData,
            'enrollments' => $this->enrollmentData,
            'users' => $this->userGrowthData
        ]);
    }

    public function loadData(ReportService $reportService)
    {
        $this->revenueData = $reportService->getRevenueData($this->period);
        $this->enrollmentData = $reportService->getEnrollmentData($this->period);
        $this->userGrowthData = $reportService->getUserGrowthData($this->period);
        $this->metrics = $reportService->getKeyMetrics();
    }

    public function exportCsv()
    {
        // Implementation for CSV export would go here
        // For now, we'll just show a notification
        session()->flash('message', 'Export started. You will receive an email when it is ready.');
    }

    public function render()
    {
        return view('livewire.admin.reports')
            ->layout('layouts.admin');
    }
}
