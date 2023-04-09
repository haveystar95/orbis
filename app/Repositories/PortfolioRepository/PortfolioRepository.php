<?php

namespace App\Repositories\PortfolioRepository;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PortfolioRepository implements PortfolioRepositoryInterface
{
	
	public function create(Portfolio $portfolio): Portfolio
	{
		return Portfolio::create([
				'user_id' => $portfolio->user_id,
				'symbol' => $portfolio->symbol,
				'shares' => $portfolio->shares,
		]);
	}
	
	public function exists($user, $symbol): bool
	{
		return $this->findByUserAndSymbol($user, $symbol) !== null;
	}
	
	public function getByUser(User $user): Collection
	{
		return Portfolio::where(['user_id' => $user->id])->get();
	}
	
	public function findById(int $id): ?Portfolio
	{
		return Portfolio::find($id);
	}
	
	public function findByUserAndSymbol($user, $symbol): ?Portfolio
	{
		return Portfolio::where(['user_id' => $user->id, 'symbol' => $symbol])->first();
	}
	
	public function update(int $id, Portfolio $portfolio): Portfolio
	{
		$portfolio->save();
		
		return $portfolio;
	}
}