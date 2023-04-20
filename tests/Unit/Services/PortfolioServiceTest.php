<?php

namespace Unit\Services;

use App\Models\Portfolio;
use App\Models\User;
use App\Repositories\HistoricalDataRepository\HistoricalDataRepository;
use App\Repositories\PortfolioRepository\PortfolioRepository;
use App\Services\PortfolioService\Exceptions\PortfolioNotFoundException;
use App\Services\PortfolioService\PortfolioService;
use App\Services\PortfolioService\PortfolioServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class PortfolioServiceTest extends TestCase
{
	protected PortfolioServiceInterface $portfolioService;
	
	protected function setUp(): void
	{
		parent::setUp();
		
		$this->portfolioService = new PortfolioService(
			new PortfolioRepository(),
			new HistoricalDataRepository()
		);
	}
	
	/**
	 * @dataProvider getValueProvider
	 * @throws Exception
	 * @throws PortfolioNotFoundException
	 */
	public function test_get_value($user, $historicalData, $symbol, $date, $expectedValue): void
	{
		$portfolioRepoMock = $this->createMock(PortfolioRepository::class);
		$historicalDataRepoMock = $this->createMock(HistoricalDataRepository::class);
		
		$portfolioRepoMock->method('findByUserAndSymbol')
			->willReturn($user->portfolio->first());
		$portfolioRepoMock->method('getByUser')
			->willReturn($user->portfolio);
		
		$historicalDataRepoMock->method('getHistoricalDataBySymbols')
			->willReturn($historicalData);
		
		$this->portfolioService = new PortfolioService($portfolioRepoMock, $historicalDataRepoMock);
		
		$value = $this->portfolioService->getValue($user, $symbol, $date);
		
		$this->assertEquals($expectedValue, $value);
	}
	
	public function getValueProvider(): array
	{
		$user = new User();
		$user->id = 1;
		
		$portfolio = new Portfolio();
		$portfolio->symbol = 'AAPL';
		$portfolio->shares = 10;
		$portfolio->user_id = 1;
		
		$user->portfolio = new Collection([
			$portfolio,
		]);
		
		return [
			'value_for_AAPL' => [
				$user,
				
				new Collection(
					['AAPL' => (object)[
						'symbol' => 'AAPL',
						'close' => 110,
						'initial_close' => 100]]
				),
				'AAPL',
				'2022-01-02',
				[
					'value' => 1100,
					'initial_value' => 1000,
					'change' => 100,
					'change_percentage' => 10,
				],
			],
		];
	}
}