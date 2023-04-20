<?php

namespace Feature\Integration\Services;

use App\Models\HistoricalData;
use App\Models\Portfolio;
use App\Models\User;
use App\Services\PortfolioService\Exceptions\PortfolioAlreadyExistsException;
use App\Services\PortfolioService\Exceptions\PortfolioNotFoundException;
use App\Services\PortfolioService\PortfolioDTO;
use App\Services\PortfolioService\PortfolioService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioServiceTest extends TestCase
{
	use RefreshDatabase;
	
	protected PortfolioService $portfolioService;
	
	protected function setUp(): void
	{
		parent::setUp();
		
		$this->portfolioService = $this->app->make(PortfolioService::class);
	}
	
	/**
	 * @throws PortfolioAlreadyExistsException
	 */
	public function test_create_portfolio(): void
	{
		$user = User::factory()->create();
		$portfolioData = [
				'symbol' => 'AAPL',
				'shares' => 10.5,
		];
		$dto = new PortfolioDTO(symbol: $portfolioData['symbol'], shares: $portfolioData['shares']);
		
		$portfolio = $this->portfolioService->create(user: $user, portfolioDTO: $dto);
		
		$this->assertInstanceOf(Portfolio::class, $portfolio);
		$this->assertEquals($portfolioData['symbol'], $portfolio->symbol);
		$this->assertEquals($portfolioData['shares'], $portfolio->shares);
		$this->assertDatabaseHas('portfolios', [
				'symbol' => 'AAPL',
				'shares' => 10.5,
		]);
	}
	
	public function test_create_portfolio_with_exists_data(): void
	{
		$user = User::factory()->create();
		$portfolioData = [
				'symbol' => 'AAPL',
				'shares' => 10.5,
		];
		$dto = new PortfolioDTO(symbol: $portfolioData['symbol'], shares: $portfolioData['shares']);
		
		$portfolio = $this->portfolioService->create(user: $user, portfolioDTO: $dto);
		
		$this->assertInstanceOf(Portfolio::class, $portfolio);
		$this->assertEquals($portfolioData['symbol'], $portfolio->symbol);
		$this->assertEquals($portfolioData['shares'], $portfolio->shares);
		$this->assertDatabaseHas('portfolios', [
				'symbol' => 'AAPL',
				'shares' => 10.5,
		]);
		
		$this->expectException(PortfolioAlreadyExistsException::class);
		$this->portfolioService->create(user: $user, portfolioDTO: $dto);
	}
	
	/**
	 * @throws PortfolioAlreadyExistsException
	 * @throws PortfolioNotFoundException
	 */
	public function test_update_portfolio(): void
	{
		$user = User::factory()->create();
		
		/** @var Portfolio $portfolio */
		$portfolio = Portfolio::factory()->create(['user_id' => $user->id]);
		
		$updatedData = [
				'symbol' => 'GOOGL',
				'shares' => 20.25,
		];
		
		$dto = new PortfolioDTO(symbol: $updatedData['symbol'], shares: $updatedData['shares']);
		
		$updatedPortfolio = $this->portfolioService->update(user: $user, id: $portfolio->id, portfolioDTO: $dto);
		
		$this->assertInstanceOf(Portfolio::class, $updatedPortfolio);
		$this->assertEquals($updatedData['symbol'], $updatedPortfolio->symbol);
		$this->assertEquals($updatedData['shares'], $updatedPortfolio->shares);
		
		$this->assertDatabaseHas('portfolios', [
				'id' => $portfolio->id,
				'symbol' => $updatedData['symbol'],
				'shares' => $updatedData['shares'],
		]);
	}
	
	/**
	 * @throws PortfolioNotFoundException
	 */
	public function test_get_portfolio_value(): void
	{
		$historicalData = HistoricalData::factory()->count(5)->create();
		$user = User::factory()->create();
		$portfolio = Portfolio::factory()->for($user, 'user')->create();
		
		$date = $historicalData->first()->date;
		$portfolioValue = $this->portfolioService->getValue(user: $user, date: $date);
		
		$this->assertIsArray($portfolioValue);
		
		$this->assertArrayHasKey('value', $portfolioValue);
		$this->assertArrayHasKey('change', $portfolioValue);
		$this->assertArrayHasKey('change_percentage', $portfolioValue);
		$this->assertArrayHasKey('initial_value', $portfolioValue);
	}
}