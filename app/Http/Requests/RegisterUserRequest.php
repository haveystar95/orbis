<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}
	
	public function rules(): array
	{
		return [
				'name' => 'required|min:3',
				'password' => 'required|min:8',
				'email' => 'required|email|unique:users'
		];
	}
}
