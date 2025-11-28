<?php

namespace App\Livewire\Admin\Coupons;

use App\Models\Coupon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['search', 'sortField', 'sortDirection'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleStatus(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);
        session()->flash('message', 'Coupon status updated.');
    }

    public function deleteCoupon(Coupon $coupon)
    {
        // Check if coupon has been used
        if ($coupon->used_count > 0) {
            session()->flash('error', 'Cannot delete coupon that has been used.');
            return;
        }

        $coupon->delete();
        session()->flash('message', 'Coupon deleted successfully.');
    }

    public function render()
    {
        $coupons = Coupon::query()
            ->when($this->search, function ($query) {
                $query->where('code', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        return view('livewire.admin.coupons.index', [
            'coupons' => $coupons,
        ]);
    }
}
