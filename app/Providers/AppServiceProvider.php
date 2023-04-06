<?php

namespace App\Providers;

use App\Repositories\UserRepository\UserRepositoryInterface;
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
		
		
	}
	
	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
	}
}
