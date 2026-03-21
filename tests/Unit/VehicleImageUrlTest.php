<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Vehicle;

class VehicleImageUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_image_url_returns_absolute_or_root_prefixed_paths()
    {
        // Absolute URL in image_url should be preserved
        $v = Vehicle::create([
            'type' => 'rental',
            'make' => 'Test',
            'model' => 'AbsoluteUrl',
            'year' => 2020,
            'plate_number' => 'PLT-ABS-001',
            'transmission' => 'automatic',
            'seats' => 4,
            'fuel_type' => 'gasoline',
            'image_url' => 'https://cdn.example.com/car.png',
        ]);

        $this->assertMatchesRegularExpression('/^(https?:\/\/)/', $v->getImageUrl());

        // Leading-slash path is returned as-is
        $v2 = Vehicle::create([
            'type' => 'rental',
            'make' => 'Test',
            'model' => 'LeadingSlash',
            'year' => 2020,
            'plate_number' => 'PLT-LS-002',
            'transmission' => 'automatic',
            'seats' => 4,
            'fuel_type' => 'gasoline',
            'image_path' => '/images/foo.png',
        ]);

        $this->assertStringStartsWith('/', $v2->getImageUrl());

        // storage path is converted to an absolute asset URL
        $v3 = Vehicle::create([
            'type' => 'rental',
            'make' => 'Test',
            'model' => 'StoragePath',
            'year' => 2020,
            'plate_number' => 'PLT-ST-003',
            'transmission' => 'automatic',
            'seats' => 4,
            'fuel_type' => 'gasoline',
            'image_path' => 'storage/images/vehicles/file.png',
        ]);

        $this->assertMatchesRegularExpression('/^(https?:\/\/|\/)/', $v3->getImageUrl());

        // relative images/... should be converted to an asset and become absolute or root-prefixed
        $v4 = Vehicle::create([
            'type' => 'rental',
            'make' => 'Test',
            'model' => 'RelativePath',
            'year' => 2020,
            'plate_number' => 'PLT-REL-004',
            'transmission' => 'automatic',
            'seats' => 4,
            'fuel_type' => 'gasoline',
            'image_url' => 'images/sample.png',
        ]);

        $this->assertMatchesRegularExpression('/^(https?:\/\/|\/)/', $v4->getImageUrl());

        // No image fields -> fallback asset (should be absolute or root-prefixed)
        $v5 = Vehicle::create([
            'type' => 'rental',
            'make' => 'Test',
            'model' => 'Fallback',
            'year' => 2020,
            'plate_number' => 'PLT-FB-005',
            'transmission' => 'automatic',
            'seats' => 4,
            'fuel_type' => 'gasoline',
        ]);

        $this->assertMatchesRegularExpression('/^(https?:\/\/|\/)/', $v5->getImageUrl());
    }
}
