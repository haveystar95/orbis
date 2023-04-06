<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\UserService\UserDTO;
use App\Services\UserService\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
	public function __construct(private readonly UserServiceInterface $userService)
	{
		$this->middleware('auth:api', ['except' => ['login', 'register']]);
	}
	
	public function register(RegisterUserRequest $request): JsonResponse
	{
		$this->userService->register(
				new UserDTO(
						email: $request->get('email'),
						name: $request->get('name'),
						password: $request->get('password')));
		
		return response()->json([
				'status' => 'success',
		]);
	}
	
	
	public function login(LoginUserRequest $request): JsonResponse
	{
		$credentials = $request->all();
		
		if (!$token = auth()->attempt($credentials)) {
			return response()->json(['error' => 'Unauthorized'], 401);
		}
		
		return $this->respondWithToken($token);
	}
	
	public function me(): JsonResponse
	{
		return response()->json(auth()->user());
	}
	
	
	public function logout(): JsonResponse
	{
		auth()->logout();
		
		return response()->json(['message' => 'Successfully logged out']);
	}
	
	public function refresh(): JsonResponse
	{
		return $this->respondWithToken(auth()->refresh());
	}
	
	protected function respondWithToken($token): JsonResponse
	{
		return response()->json([
				'access_token' => $token,
				'token_type' => 'bearer',
				'expires_in' => auth()->factory()->getTTL() * 60
		]);
	}
}
