<?php

namespace App\Services\UserService\Exceptions;

use App\Exceptions\ClientException;

class UserAlreadyExistsException extends ClientException
{
	protected function getCustomMessage(): string
	{
		return 'User with this email already exists';
	}
	
	protected function getCustomCode(): int
	{
		return 400;
	}
}