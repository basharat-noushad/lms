<?php

namespace App\Livewire\Instructor\Withdrawals;

use App\Models\Earning;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $amount;
    public $payment_method = 'paypal';
    public $payment_details = '';

    public function requestWithdrawal()
    {
        $instructorId = Auth::id();
        $availableBalance = Earning::where('instructor_id', $instructorId)->where('status', 'available')->sum('amount');
        
        // Subtract pending withdrawals from available balance check
        $pendingWithdrawals = Withdrawal::where('instructor_id', $instructorId)->where('status', 'pending')->sum('amount');
        $realAvailable = $availableBalance - $pendingWithdrawals;

        $this->validate([
            'amount' => 'required|numeric|min:10|max:' . $realAvailable,
            'payment_method' => 'required|in:paypal,bank_transfer',
            'payment_details' => 'required|string',
        ]);

        Withdrawal::create([
            'instructor_id' => $instructorId,
            'amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'payment_details' => $this->payment_details,
            'status' => 'pending',
        ]);

        $this->reset(['amount', 'payment_details']);
        session()->flash('message', 'Withdrawal request submitted successfully.');
    }

    public function render()
    {
        $withdrawals = Withdrawal::where('instructor_id', Auth::id())
            ->latest()
            ->paginate(10);

        $instructorId = Auth::id();
        $availableBalance = Earning::where('instructor_id', $instructorId)->where('status', 'available')->sum('amount');
        $pendingWithdrawals = Withdrawal::where('instructor_id', $instructorId)->where('status', 'pending')->sum('amount');
        $withdrawableAmount = max(0, $availableBalance - $pendingWithdrawals);

        return view('livewire.instructor.withdrawals.index', [
            'withdrawals' => $withdrawals,
            'withdrawableAmount' => $withdrawableAmount,
        ])->layout('layouts.instructor');
    }
}
