<?php

namespace Feature\Api;

use App\Models\HistoricalData;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PortfolioApiTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;
	
	public function test_user_can_create_a_portfolio(): void
	{
		$user = User::factory()->create();
		
		/** @var HistoricalData $history */
		$history = HistoricalData::factory()->create();
		$symbol = $history->symbol;
		$shares = 10.12345;
		
		$response = $this->actingAs($user, 'api')->postJson('/api/portfolio', [
				'symbol' => $symbol,
				'shares' => $shares,
		]);
		
		$response->assertStatus(201);
		$this->assertDatabaseHas('portfolios', [
				'user_id' => $user->id,
				'symbol' => $symbol,
				'shares' => $shares,
		]);
	}
	
	public function test_user_cannot_create_a_portfolio_exists_symbol(): void
	{
		$user = User::factory()->create();
		
		/** @var HistoricalData $history */
		$history = HistoricalData::factory()->create();
		
		/** @var Portfolio $existsPortfolio */
		$existsPortfolio = Portfolio::factory()->create(['user_id' => $user->id, 'symbol' => $history->symbol]);
		
		$symbol = $existsPortfolio->symbol;
		$shares = 10.12345;
		
		$response = $this->actingAs($user, 'api')->postJson('/api/portfolio', [
				'symbol' => $symbol,
				'shares' => $shares,
		]);
		
		$response->assertStatus(401);
		$this->assertDatabaseMissing('portfolios', [
				'user_id' => $user->id,
				'symbol' => $symbol,
				'shares' => $shares,
		]);
	}
	
	public function test_user_can_view_their_portfolio(): void
	{
		$user = User::factory()->create();
		$portfolio = Portfolio::factory()->create(['user_id' => $user->id]);
		
		$response = $this->actingAs($user, 'api')->getJson('/api/portfolio');
		
		$response
				->assertStatus(200)
				->assertJsonFragment([
						'id' => $portfolio->id,
						'symbol' => $portfolio->symbol,
						'shares' => $portfolio->shares,
				]);
	}
	
	public function test_user_can_update_their_portfolio(): void
	{
		$user = User::factory()->create();
		
		/** @var HistoricalData $history */
		$history = HistoricalData::factory()->create();
		
		/** @var Portfolio $portfolio */
		$portfolio = Portfolio::factory()->create(['user_id' => $user->id, 'symbol' => $history->symbol]);
		$updatedShares = 20.12345;
		
		$response = $this->actingAs($user, 'api')->putJson("/api/portfolio/{$portfolio->id}", [
				'shares' => $updatedShares,
				'symbol' => $portfolio->symbol,
		]);
		
		$response->assertStatus(200);
		$this->assertDatabaseHas('portfolios', [
				'id' => $portfolio->id,
				'shares' => $updatedShares,
		]);
	}
	
	public function test_user_can_get_portfolio_value(): void
	{
		$user = User::factory()->create();
		
		/** @var HistoricalData $history */
		$history = HistoricalData::factory()->create();
		
		Portfolio::factory()->create(['user_id' => $user->id, 'symbol' => $history->symbol]);
		
		$response = $this->actingAs($user, 'api')->getJson('/api/portfolio/value');
		
		$response
				->assertStatus(200)
				->assertJsonStructure([
						'value',
						'initial_value',
						'change',
						'change_percentage',
				]);
	}
}