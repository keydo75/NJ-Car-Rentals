<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_loads()
    {
        $response = $this->get(route('customer.register'));
        $response->assertStatus(200);
        $response->assertSee('Customer Registration');
    }

    public function test_customer_can_register_and_login()
    {
        $payload = [
            'name' => 'New Customer',
            'email' => 'newcustomer@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '09170000000',
            'address' => 'Somewhere',
        ];

        $response = $this->post(route('customer.register.submit'), $payload);
        $response->assertRedirect(route('customer.dashboard'));

        $this->assertDatabaseHas('customers', [
            'email' => 'newcustomer@example.com',
            'name' => 'New Customer'
        ]);

        // ensure customer is authenticated on customer guard
        $this->assertTrue(auth()->guard('customer')->check());
    }
}
