<?php

namespace App\Providers;

use App\Repositories\HistoricalDataRepository\HistoricalDataRepositoryInterface;
use App\Repositories\PortfolioRepository\PortfolioRepositoryInterface;
use App\Repositories\UserRepository\UserRepositoryInterface;
use App\Services\PortfolioService\PortfolioService;
use App\Services\PortfolioService\PortfolioServiceInterface;
use App\Services\UserService\UserFactory;
use App\Services\UserService\UserService;
use App\Services\UserService\UserServiceInterface;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		if ($this->app->isLocal()) {
			$this->app->register(IdeHelperServiceProvider::class);
		}
		
		$this->app->singleton(UserServiceInterface::class,
				function (): UserServiceInterface {
					return new UserService(new UserFactory(),
							$this->app->make(UserRepositoryInterface::class));
				});
		
		$this->app->singleton(PortfolioServiceInterface::class,
				function (): PortfolioServiceInterface {
					return new PortfolioService(
							$this->app->make(PortfolioRepositoryInterface::class),
							$this->app->make(HistoricalDataRepositoryInterface::class),
					);
				});
		
		
	}
	
	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
	}
}
