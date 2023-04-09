<?php

namespace App\Repositories\PortfolioRepository;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface PortfolioRepositoryInterface
{
	public function create(Portfolio $portfolio): Portfolio;
	
	public function update(int $id, Portfolio $portfolio): Portfolio;
	
	public function exists(User $user, string $symbol): bool;
	
	public function getByUser(User $user): Collection;
	
	public function findById(int $id): ?Portfolio;
	
	public function findByUserAndSymbol(User $user, string $symbol): ?Portfolio;

}