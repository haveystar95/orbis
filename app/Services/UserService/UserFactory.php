<?php

namespace App\Services\UserService;

use App\Models\User;

class UserFactory
{
	public function create(UserDTO $userDTO): User
	{
		$user = new User();
		$user->name = $userDTO->name;
		$user->email = $userDTO->email;
		$user->password = \Hash::make($userDTO->password);
		
		return $user;
	}
}