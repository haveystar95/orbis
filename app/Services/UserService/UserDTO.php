<?php

namespace App\Services\UserService;

class UserDTO
{
	public function __construct(
			public readonly string $email,
			public readonly string $name,
			public readonly string $password)
	{
	}
}