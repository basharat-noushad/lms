<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use App\Services\Payment\PayPalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_user_can_initiate_checkout()
    {
        $user = User::factory()->create();
        $instructor = User::factory()->create(['role' => 'instructor']);
        $category = Category::create(['name' => 'Test Category', 'slug' => 'test-category', 'is_active' => true]);
        $course = Course::create([
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
            'title' => 'Test Course',
            'slug' => 'test-course',
            'subtitle' => 'Test Subtitle',
            'description' => 'Test Description',
            'requirements' => 'Test Requirements',
            'what_you_learn' => 'Test Outcomes',
            'price' => 100,
            'level' => 'beginner',
            'status' => 'published',
        ]);

        $mockPayPal = $this->createMock(PayPalService::class);
        $mockPayPal->method('createOrder')
            ->willReturn([
                'id' => 'ORDER-123',
                'status' => 'CREATED',
                'links' => [
                    ['rel' => 'approve', 'href' => 'https://paypal.com/approve']
                ]
            ]);

        $this->app->instance(PayPalService::class, $mockPayPal);
        
        // Mock the controller action or service differently if possible, 
        // but for now let's see if it crashes without this.
        // We expect it to fail (redirect to error or crash in controller), but not "0 assertions" crash.
        
        $response = $this->actingAs($user)
            ->get(route('checkout', $course));

        $response->assertRedirect('https://paypal.com/approve');
        
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => 'pending',
            'total_amount' => 100,
        ]);

        $this->assertDatabaseHas('order_items', [
            'course_id' => $course->id,
            'price' => 100,
        ]);
    }

    public function test_checkout_callback_processes_payment_and_enrolls_user()
    {
        $user = User::factory()->create();
        $instructor = User::factory()->create(['role' => 'instructor']);
        $category = Category::create(['name' => 'Test Category 2', 'slug' => 'test-category-2', 'is_active' => true]);
        $course = Course::create([
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
            'title' => 'Test Course 2',
            'slug' => 'test-course-2',
            'subtitle' => 'Test Subtitle',
            'description' => 'Test Description',
            'requirements' => 'Test Requirements',
            'what_you_learn' => 'Test Outcomes',
            'price' => 100,
            'level' => 'beginner',
            'status' => 'published',
        ]);
        
        $order = Order::create([
            'user_id' => $user->id,
            'subtotal' => 100,
            'total_amount' => 100,
            'status' => 'pending',
            'payment_method' => 'paypal',
        ]);

        $order->items()->create([
            'course_id' => $course->id,
            'instructor_id' => $course->instructor_id,
            'price' => 100,
            'instructor_share' => 70,
            'platform_share' => 30,
            'total' => 100,
        ]);

        $mockPayPal = Mockery::mock(PayPalService::class);
        $mockPayPal->shouldReceive('capturePayment')
            ->once()
            ->andReturn([
                'id' => 'TRANS-123',
                'status' => 'COMPLETED'
            ]);

        $this->app->instance(PayPalService::class, $mockPayPal);

        $response = $this->actingAs($user)
            ->get(route('checkout.callback', ['order' => $order->id, 'token' => 'TOKEN-123']));

        $response->assertRedirect(route('checkout.success'));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid',
            'transaction_id' => 'TRANS-123',
        ]);

        $this->assertTrue($user->hasPurchased($course));
    }

    public function test_free_course_enrollment_skips_payment()
    {
        $user = User::factory()->create();
        $instructor = User::factory()->create(['role' => 'instructor']);
        $category = Category::create(['name' => 'Test Category 3', 'slug' => 'test-category-3', 'is_active' => true]);
        $course = Course::create([
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
            'title' => 'Test Course 3',
            'slug' => 'test-course-3',
            'subtitle' => 'Test Subtitle',
            'description' => 'Test Description',
            'requirements' => 'Test Requirements',
            'what_you_learn' => 'Test Outcomes',
            'price' => 0,
            'level' => 'beginner',
            'status' => 'published',
            'is_free' => true,
        ]);

        $response = $this->actingAs($user)
            ->get(route('checkout', $course));

        $response->assertRedirect(route('courses.show', $course));
        $response->assertSessionHas('success');

        $this->assertTrue($user->hasPurchased($course));
    }
}
