<?php

namespace App\Livewire\Instructor\Coupons;

use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $code;
    public $type = 'percent';
    public $value;
    public $usage_limit;
    public $expires_at;
    public $is_active = true;

    public function updatedCode()
    {
        $this->code = strtoupper($this->code);
    }

    public function save()
    {
        $this->validate([
            'code' => 'required|string|unique:coupons,code|min:3|max:20',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:today',
            'is_active' => 'boolean',
        ]);

        Coupon::create([
            'instructor_id' => Auth::id(),
            'code' => $this->code,
            'type' => $this->type,
            'value' => $this->value,
            'usage_limit' => $this->usage_limit,
            'expires_at' => $this->expires_at,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Coupon created successfully.');
        return redirect()->route('instructor.coupons.index');
    }

    public function render()
    {
        return view('livewire.instructor.coupons.create')->layout('layouts.instructor');
    }
}
