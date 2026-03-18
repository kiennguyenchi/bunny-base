<?php

namespace Database\Factories;

use App\Models\Rabbit;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rabbit>
 */
class RabbitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::count() > 0 ? Tenant::inRandomOrder()->first()->id : Tenant::factory(),
            'name' => $this->faker->firstName(),
            'tattoo_id' => $this->faker->unique()->bothify('??-#####'),
            'sex' => $this->faker->randomElement(['buck', 'doe']),
            'sire_id' => null,
            'dam_id' => null,
        ];
    }
}
