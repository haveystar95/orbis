<?php

namespace App\Services\PortfolioService;

use App\Helpers\MathHelper;
use App\Models\Portfolio;
use App\Models\User;
use App\Repositories\HistoricalDataRepository\HistoricalDataRepositoryInterface;
use App\Repositories\PortfolioRepository\PortfolioRepositoryInterface;
use App\Services\PortfolioService\Exceptions\PortfolioAlreadyExistsException;
use App\Services\PortfolioService\Exceptions\PortfolioNotFoundException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class PortfolioService implements PortfolioServiceInterface
{
	public function __construct(
			private readonly PortfolioRepositoryInterface      $portfolioRepository,
			private readonly HistoricalDataRepositoryInterface $historicalDataRepository)
	{
	}
	
	/**
	 * @throws PortfolioAlreadyExistsException
	 */
	public function create(User $user, PortfolioDTO $portfolioDTO): Portfolio
	{
		$portfolio = new Portfolio();
		$portfolio->symbol = $portfolioDTO->symbol;
		$portfolio->shares = $portfolioDTO->shares;
		$portfolio->user_id = $user->id;
		
		if ($this->portfolioRepository->exists($user, $portfolioDTO->symbol)) {
			throw new PortfolioAlreadyExistsException();
		}
		
		return $this->portfolioRepository->create($portfolio);
	}
	
	/**
	 * @throws PortfolioNotFoundException|PortfolioAlreadyExistsException
	 */
	public function update(User $user, int $id, PortfolioDTO $portfolioDTO): Portfolio
	{
		$portfolio = $this->portfolioRepository->findById($id);
		
		if (!$portfolio || $portfolio->user_id !== $user->id) {
			throw new PortfolioNotFoundException();
		}
		
		if ($portfolio->symbol !== $portfolioDTO->symbol) {
			$portfolioSameSymbol = $this->portfolioRepository->findByUserAndSymbol($user, $portfolioDTO->symbol);
			
			if ($portfolioSameSymbol && $portfolioSameSymbol->id !== $portfolio->id) {
				throw new PortfolioAlreadyExistsException();
			}
		}
		
		$portfolio->symbol = $portfolioDTO->symbol;
		$portfolio->shares = $portfolioDTO->shares;
		
		return $this->portfolioRepository->update($id, $portfolio);
	}
	
	public function list(User $user): Collection
	{
		return $this->portfolioRepository->getByUser($user);
	}
	
	/**
	 * @throws PortfolioNotFoundException
	 */
	public function getValue(User $user, ?string $symbol = null, string $date = null): ?array
	{
		$date = !is_null($date) ? Carbon::parse($date) : null;
		
		if ($symbol) {
			$portfolio = $this->portfolioRepository->findByUserAndSymbol($user, $symbol);
			$portfolios = $portfolio === null ? Collection::make() : Collection::make([$portfolio]);
		} else {
			$portfolios = $this->portfolioRepository->getByUser($user);
		}
		
		if ($portfolios->isEmpty()) {
			throw new PortfolioNotFoundException();
		}
		
		$symbols = $portfolios->pluck('symbol')->unique()->toArray();
		$historicalData = $this->historicalDataRepository->getHistoricalDataBySymbols($symbols, $date);
		
		$portfolioValue = 0;
		$initialValue = 0;
		$change = 0;
		$changePercentage = 0;
		
		foreach ($portfolios as $portfolio) {
			$symbolHistoricalData = $historicalData->get($portfolio->symbol);
			
			if ($symbolHistoricalData) {
				$value = $portfolio->shares * $symbolHistoricalData->close;
				$portfolioValue += $value;
				$initialValue += $portfolio->shares * $symbolHistoricalData->initial_close;
			}
		}
		
		if ($initialValue > 0) {
			$change = $portfolioValue - $initialValue;
			$changePercentage = MathHelper::getChangePercentage($change, $initialValue);
		}
		
		return [
				'value' => MathHelper::roundFloatShares($portfolioValue),
				'initial_value' => MathHelper::roundFloatShares($initialValue),
				'change' => MathHelper::roundFloatShares($change),
				'change_percentage' => MathHelper::roundPercentage($changePercentage),
		];
	}
}