<?php

namespace Tests\Feature\Instructor;

use App\Models\User;
use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Instructor\Coupons\Index;
use App\Livewire\Instructor\Coupons\Create;

class CouponTest extends TestCase
{
    use RefreshDatabase;

    public function test_instructor_can_view_coupons()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $coupon = Coupon::factory()->create(['instructor_id' => $instructor->id]);

        Livewire::actingAs($instructor)
            ->test(Index::class)
            ->assertSee($coupon->code);
    }

    public function test_instructor_can_create_coupon()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);

        Livewire::actingAs($instructor)
            ->test(Create::class)
            ->set('code', 'TESTCOUPON')
            ->set('type', 'percent')
            ->set('value', 10)
            ->call('save');

        $this->assertDatabaseHas('coupons', [
            'instructor_id' => $instructor->id,
            'code' => 'TESTCOUPON',
        ]);
    }

    public function test_instructor_can_delete_unused_coupon()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $coupon = Coupon::factory()->create(['instructor_id' => $instructor->id, 'times_used' => 0]);

        Livewire::actingAs($instructor)
            ->test(Index::class)
            ->call('deleteCoupon', $coupon->id);

        $this->assertDatabaseMissing('coupons', ['id' => $coupon->id]);
    }
}
