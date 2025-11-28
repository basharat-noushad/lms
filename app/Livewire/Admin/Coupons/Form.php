<?php

namespace App\Livewire\Admin\Coupons;

use App\Models\Coupon;
use Livewire\Component;

class Form extends Component
{
    public ?Coupon $coupon = null;
    
    public $code = '';
    public $type = 'fixed';
    public $value = 0;
    public $start_date;
    public $end_date;
    public $usage_limit;
    public $is_active = true;

    public function mount(?Coupon $coupon = null)
    {
        if ($coupon && $coupon->exists) {
            $this->coupon = $coupon;
            $this->code = $coupon->code;
            $this->type = $coupon->type;
            $this->value = $coupon->value;
            $this->start_date = $coupon->start_date ? $coupon->start_date->format('Y-m-d') : null;
            $this->end_date = $coupon->end_date ? $coupon->end_date->format('Y-m-d') : null;
            $this->usage_limit = $coupon->usage_limit;
            $this->is_active = $coupon->is_active;
        }
    }

    protected function rules()
    {
        $id = $this->coupon ? $this->coupon->id : 'NULL';
        
        return [
            'code' => 'required|string|max:50|unique:coupons,code,' . $id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'code' => strtoupper($this->code),
            'type' => $this->type,
            'value' => $this->value,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'usage_limit' => $this->usage_limit,
            'is_active' => $this->is_active,
        ];

        if ($this->coupon) {
            $this->coupon->update($data);
            session()->flash('message', 'Coupon updated successfully.');
        } else {
            Coupon::create($data);
            session()->flash('message', 'Coupon created successfully.');
        }

        return redirect()->route('admin.coupons.index');
    }

    public function render()
    {
        return view('livewire.admin.coupons.form');
    }
}
