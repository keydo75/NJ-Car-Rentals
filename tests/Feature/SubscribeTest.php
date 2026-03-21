<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Subscription;

class SubscribeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_subscribe_via_post()
    {
        $response = $this->post(route('subscribe'), ['email' => 'test@example.com']);
        $response->assertRedirect();
        $this->assertDatabaseHas('subscriptions', ['email' => 'test@example.com']);
    }

    public function test_cannot_subscribe_with_duplicate_email()
    {
        Subscription::create(['email' => 'dup@example.com']);
        $response = $this->post(route('subscribe'), ['email' => 'dup@example.com']);
        $response->assertSessionHasErrors('email');
    }

    public function test_subscribe_endpoint_returns_json_when_requested()
    {
        $response = $this->postJson(route('subscribe'), ['email' => 'json@example.com']);
        $response->assertStatus(201)->assertJson(['message' => 'Thanks — you are subscribed.']);
        $this->assertDatabaseHas('subscriptions', ['email' => 'json@example.com']);
    }
}