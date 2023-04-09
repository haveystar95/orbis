<?php

namespace App\Providers;

use App\Repositories\HistoricalDataRepository\HistoricalDataRepository;
use App\Repositories\HistoricalDataRepository\HistoricalDataRepositoryInterface;
use App\Repositories\PortfolioRepository\PortfolioRepository;
use App\Repositories\PortfolioRepository\PortfolioRepositoryInterface;
use App\Repositories\UserRepository\UserRepository;
use App\Repositories\UserRepository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind(
				UserRepositoryInterface::class,
				UserRepository::class,
		);
		
		$this->app->bind(
				HistoricalDataRepositoryInterface::class,
				HistoricalDataRepository::class,
		);
		
		$this->app->bind(
				PortfolioRepositoryInterface::class,
				PortfolioRepository::class,
		);
	}
	
	public function boot(): void
	{
	
	}
}