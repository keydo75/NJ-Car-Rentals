<?php

namespace Tests\Feature\Database;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Vehicle;
use App\Models\Rental;
use App\Models\User;

class SoftDeletesTest extends TestCase
{
    use RefreshDatabase;

    public function test_vehicle_soft_delete_hides_from_available_scope()
    {
        $vehicle = Vehicle::create([
            'type' => 'rental',
            'make' => 'Test',
            'model' => 'Car',
            'year' => 2020,
            'plate_number' => 'TEST' . rand(1000,9999),
            'price_per_day' => 1000,
            'status' => 'available',
            'transmission' => 'automatic',
            'seats' => 4,
            'fuel_type' => 'gasoline',
        ]);

        $this->assertDatabaseHas('vehicles', ['id' => $vehicle->id, 'deleted_at' => null]);
        $this->assertTrue(Vehicle::available()->where('id', $vehicle->id)->exists());

        $vehicle->delete();

        $this->assertSoftDeleted('vehicles', ['id' => $vehicle->id]);
        $this->assertFalse(Vehicle::available()->where('id', $vehicle->id)->exists());
        $this->assertTrue(Vehicle::withTrashed()->where('id', $vehicle->id)->exists());
    }

    public function test_rental_soft_delete()
    {
        $user = User::factory()->create();

        $vehicle = Vehicle::create([
            'type' => 'rental',
            'make' => 'Test',
            'model' => 'Car',
            'year' => 2020,
            'plate_number' => 'TEST' . rand(10000,19999),
            'price_per_day' => 1000,
            'status' => 'available',
            'transmission' => 'automatic',
            'seats' => 4,
            'fuel_type' => 'gasoline',
        ]);

        $rental = Rental::create([
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'days' => 2,
            'total_price' => 2000,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('rentals', ['id' => $rental->id, 'deleted_at' => null]);

        $rental->delete();

        $this->assertSoftDeleted('rentals', ['id' => $rental->id]);
    }
}
