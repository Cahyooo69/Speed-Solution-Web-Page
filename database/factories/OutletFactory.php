<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outlet>
 */
class OutletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $regions = ['SIDOARJO', 'SURABAYA', 'GRESIK', 'MALANG'];
        
        return [
            'name' => 'Speed Solution ' . $this->faker->city(),
            'phone' => '0' . $this->faker->numerify('8########'),
            'address' => $this->faker->address(),
            'region' => $this->faker->randomElement($regions),
            'maps_url' => 'https://www.google.com/maps',
            'is_active' => true,
        ];
    }
}
