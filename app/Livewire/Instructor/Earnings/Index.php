<?php

namespace App\Livewire\Instructor\Earnings;

use App\Models\Earning;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $instructorId = Auth::id();

        $totalEarnings = Earning::where('instructor_id', $instructorId)->sum('amount');
        // Assuming we have a status column or similar logic for available/pending
        // For MVP, let's assume all earnings are available for now, or add logic later
        $availableBalance = Earning::where('instructor_id', $instructorId)->where('status', 'available')->sum('amount');
        $pendingBalance = Earning::where('instructor_id', $instructorId)->where('status', 'pending')->sum('amount');

        $earnings = Earning::where('instructor_id', $instructorId)
            ->latest()
            ->paginate(10);

        return view('livewire.instructor.earnings.index', [
            'totalEarnings' => $totalEarnings,
            'availableBalance' => $availableBalance,
            'pendingBalance' => $pendingBalance,
            'earnings' => $earnings,
        ])->layout('layouts.instructor');
    }
}
