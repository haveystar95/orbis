<?php

namespace App\Services\PortfolioService\Exceptions;

use App\Exceptions\ClientException;

class PortfolioAlreadyExistsException extends ClientException
{
	
	protected function getCustomMessage(): string
	{
		return 'Portfolio with this symbol already exists';
	}
	
	protected function getCustomCode(): int
	{
		return 401;
	}
}