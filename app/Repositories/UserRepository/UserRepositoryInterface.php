<?php

namespace App\Repositories\UserRepository;

use App\Models\User;

interface UserRepositoryInterface
{
	public function create(User $user): User;
	
	public function findByEmail(string $email): ?User;
}