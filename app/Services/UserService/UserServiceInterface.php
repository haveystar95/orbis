<?php

namespace App\Services\UserService;

use App\Models\User;

interface UserServiceInterface
{
	public function register(UserDTO $userDTO): User;
}