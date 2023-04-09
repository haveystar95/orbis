<?php

namespace App\Services\PortfolioService\Exceptions;

use App\Exceptions\ClientException;

class PortfolioNotFoundException extends ClientException
{
	protected function getCustomMessage(): string
	{
		return 'Portfolio nof found';
	}
	
	protected function getCustomCode(): int
	{
		return 404;
	}
}