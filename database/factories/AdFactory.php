<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use App\Models\Ad; // Ensure you import the correct model

class AdFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company, // Generates a random company name
            'caption' => $this->faker->text(200), // Generates random text
            'link' => $this->faker->url, // Generates a random URL
            'price' => $this->faker->randomFloat(2, 100, 10000), // Generates a random price between 100 and 10,000
            'ad_type' => $this->faker->randomElement(['cars', 'workshops', 'spare parts']), // Random ad type
            'appearance_qty' => $this->faker->numberBetween(1, 100), // Random number of appearances
            'is_active' => $this->faker->boolean, // Randomly true or false
            'from' => $this->faker->dateTimeBetween('-1 month', '+1 month'), // Random start date
            'to' => $this->faker->dateTimeBetween('+2 months', '+6 months'), // Random end date
            'views' => $this->faker->numberBetween(0, 5000), // Random views count
            'brand_id' => Arr::random([5, 10, 15, 20, 25, 30]), // Random brand ID from the given list
            'user_id' => $this->faker->numberBetween(700, 750), // Random user ID between 700 and 750
        ];
    }
}
