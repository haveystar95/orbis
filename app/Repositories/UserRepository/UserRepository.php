<?php

namespace App\Repositories\UserRepository;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
	/**
	 * @throws Throwable
	 */
	public function create(User $user): User
	{
		User::create([
				'name' => $user->name,
				'email' => $user->email,
				'password' => $user->password,
		]);
		
		return $user;
	}
	
	public function findByEmail(string $email): ?User
	{
		return User::where(['email' => $email])->first();
	}
}