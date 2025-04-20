<?php 
namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    protected $model = Package::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->word(),
            'period' => $this->faker->numberBetween(1, 12),
            'period_type' => $this->faker->randomElement(['Months', 'Years']),
            'provider' => $this->faker->randomElement(['Car Provider','Spare Part Provider','workshop','Workshop Provider']),
            'price' => $this->faker->numberBetween(100, 1000),
            'limits' => $this->faker->numberBetween(1, 100),
        ];
    }
}
