<?php

namespace App\Livewire\Instructor\Coupons;

use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus(Coupon $coupon)
    {
        if ($coupon->instructor_id !== Auth::id()) {
            abort(403);
        }

        $coupon->update(['is_active' => !$coupon->is_active]);
        session()->flash('message', 'Coupon status updated successfully.');
    }

    public function deleteCoupon(Coupon $coupon)
    {
        if ($coupon->instructor_id !== Auth::id()) {
            abort(403);
        }

        if ($coupon->times_used > 0) {
            session()->flash('error', 'Cannot delete coupon that has been used.');
            return;
        }

        $coupon->delete();
        session()->flash('message', 'Coupon deleted successfully.');
    }

    public function render()
    {
        $coupons = Coupon::where('instructor_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('code', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.instructor.coupons.index', [
            'coupons' => $coupons,
        ])->layout('layouts.instructor');
    }
}
