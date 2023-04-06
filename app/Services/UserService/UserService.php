<?php

namespace App\Services\UserService;

use App\Models\User;
use App\Repositories\UserRepository\UserRepositoryInterface;
use App\Services\UserService\Exceptions\UserAlreadyExistsException;

class UserService implements UserServiceInterface
{
	public function __construct(
			private readonly UserFactory             $userFactory,
			private readonly UserRepositoryInterface $userRepository)
	{
	}
	
	/**
	 * @throws UserAlreadyExistsException
	 */
	public function register(UserDTO $userDTO): User
	{
		if ($this->userRepository->findByEmail($userDTO->email)) {
			throw new UserAlreadyExistsException();
		}
		
		$user = $this->userFactory->create($userDTO);
		
		return $this->userRepository->create($user);
	}
}