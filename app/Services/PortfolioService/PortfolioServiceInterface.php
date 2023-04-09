<?php

namespace App\Services\PortfolioService;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface PortfolioServiceInterface
{
	public function create(User $user, PortfolioDTO $portfolioDTO): Portfolio;
	
	public function list(User $user,): Collection;
	
	public function update(User $user, int $id, PortfolioDTO $portfolioDTO);
	
	public function getValue(User $user, string $symbol, string $date);
	
}