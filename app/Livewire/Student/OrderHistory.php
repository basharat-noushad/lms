<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderHistory extends Component
{
    use WithPagination;

    public function downloadInvoice($orderId)
    {
        $order = Auth::user()->orders()->with(['items.course', 'user'])->findOrFail($orderId);
        
        $pdf = Pdf::loadView('student.invoice', ['order' => $order]);
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'invoice-' . $order->order_number . '.pdf');
    }

    public function render()
    {
        $orders = Auth::user()->orders()
            ->with(['items.course'])
            ->latest()
            ->paginate(10);

        return view('livewire.student.order-history', [
            'orders' => $orders
        ])->layout('layouts.student');
    }
}
