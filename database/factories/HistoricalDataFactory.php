<?php

namespace Database\Factories;

use App\Models\HistoricalData;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HistoricalData>
 */
class HistoricalDataFactory extends Factory
{
	protected $model = HistoricalData::class;
	
	/**
	 * Define the model's default state.
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
				'symbol' => $this->faker->randomElement(['AAPL', 'GOOGL', 'AMZN', 'TSLA', 'MSFT']),
				'date' => $this->faker->unique()->date($format = 'Y-m-d', $max = 'now'),
				'open' => $this->faker->randomFloat(2, 100, 10000),
				'high' => $this->faker->randomFloat(2, 100, 10000),
				'low' => $this->faker->randomFloat(2, 100, 10000),
				'close' => $this->faker->randomFloat(2, 100, 10000),
				'volume' => $this->faker->numberBetween(1000000, 100000000),
		];
	}
}
