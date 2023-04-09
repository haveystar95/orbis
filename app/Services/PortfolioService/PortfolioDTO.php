<?php

namespace App\Services\PortfolioService;

class PortfolioDTO
{
	public function __construct(public readonly string $symbol, public readonly string $shares)
	{
	}
	
	public static function fromRequest(array $validatedData): self
	{
		return new self(
				symbol: $validatedData['symbol'],
				shares: $validatedData['shares'],
		);
	}
}