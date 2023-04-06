<?php

namespace App\Providers;

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
	}
	
	public function boot(): void
	{
	
	}
}