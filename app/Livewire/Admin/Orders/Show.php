<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;

class Show extends Component
{
    public Order $order;
    public $refundReason = '';
    public $showRefundModal = false;

    public function mount(Order $order)
    {
        $this->order = $order->load(['user', 'items.course']);
    }

    public function openRefundModal()
    {
        $this->showRefundModal = true;
    }

    public function processRefund()
    {
        $this->validate([
            'refundReason' => 'required|string|min:5',
        ]);

        // In a real app, we would call Stripe/PayPal API here
        
        $this->order->update([
            'status' => 'refunded',
            // Store refund reason/transaction ID
        ]);

        // Update enrollments? Usually we disable access.
        foreach ($this->order->items as $item) {
            // Find enrollment and cancel it?
            // For MVP, we might just leave it or manually handle it.
            // Let's assume we just mark order as refunded for now.
        }

        $this->showRefundModal = false;
        session()->flash('message', 'Order refunded successfully.');
    }

    public function render()
    {
        return view('livewire.admin.orders.show');
    }
}
