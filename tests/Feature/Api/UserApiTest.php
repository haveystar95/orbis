<?php

namespace Feature\Api;

use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JsonException;
use Tests\TestCase;

class UserApiTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;
	
	/**
	 * @throws JsonException
	 */
	public function test_user_can_register(): void
	{
		$user = [
				'name' => $this->faker->name,
				'email' => $this->faker->unique()->safeEmail,
				'password' => 'password',
		];
		
		$response = $this->postJson('/api/auth/register', $user);
		
		$response
				->assertStatus(200)
				->assertJsonStructure([
						'status'
				])->assertContent(json_encode(["status" => "success"], JSON_THROW_ON_ERROR));
	}
	
	public function test_user_cannot_register(): void
	{
		$user = [
				'name' => $this->faker->name,
				'email' => 'not_valid_email',
				'password' => 'password',
		];
		
		$response = $this->postJson('/api/auth/register', $user);
		
		$response
				->assertStatus(422)
				->assertJsonStructure([
						'message',
						'errors',
				])
				->assertContent('{"message":"The email field must be a valid email address.","errors":{"email":["The email field must be a valid email address."]}}');
	}
	
	public function test_user_can_login(): void
	{
		$password = 'password';
		$user = User::factory()->create([
				'password' => Hash::make($password),
		]);
		
		$response = $this->postJson('/api/auth/login', [
				'email' => $user->email,
				'password' => $password,
		]);
		
		$response
				->assertStatus(200)
				->assertJsonStructure([
						'access_token',
						'token_type',
						'expires_in',
				]);
	}
	
	public function test_user_cannot_login(): void
	{
		$password = 'password';
		$user = User::factory()->create([
				'password' => Hash::make($password),
		]);
		
		$response = $this->postJson('/api/auth/login', [
				'email' => $user->email,
				'password' => 'wrong_password',
		]);
		
		$response
				->assertStatus(401)
				->assertJsonStructure([
						'error',
				])
				->assertContent('{"error":"Unauthorized"}');
	}
	
	public function a_user_can_logout(): void
	{
		$user = User::factory()->create();
		
		$response = $this->actingAs($user, 'api')->postJson('/api/auth/logout');
		
		$response->assertStatus(200);
	}
	
	public function test_user_can_view_their_own_profile(): void
	{
		$user = User::factory()->create();
		
		$response = $this->actingAs($user, 'api')->postJson('/api/auth/me');
		$response
				->assertStatus(200)
				->assertExactJson([
						'id' => $user->id,
						'name' => $user->name,
						'email' => $user->email,
						'email_verified_at' => $user->email_verified_at,
						'created_at' => $user->created_at,
						'updated_at' => $user->updated_at,
				]);
	}
	
	public function test_user_cannot_view_their_own_profile(): void
	{
		$user = User::factory()->create();
		
		$response = $this->postJson('/api/auth/me');
		$response
				->assertStatus(401)
				->assertExactJson([
						'message' => 'Unauthenticated.'
				]);
	}
}