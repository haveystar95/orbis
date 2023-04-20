<?php

namespace Database\Factories;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio>
 */
class PortfolioFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 * @var string
	 */
	protected $model = Portfolio::class;
	
	/**
	 * Define the model's default state.
	 * @return array
	 */
	public function definition(): array
	{
		return [
				'user_id' => User::factory(),
				'symbol' => $this->faker->randomElement(['AAPL', 'GOOGL', 'AMZN', 'TSLA', 'MSFT']),
				'shares' => $this->faker->randomFloat(5, 1, 1000),
		];
	}
}
