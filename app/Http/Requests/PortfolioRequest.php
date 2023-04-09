<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}
	
	public function rules(): array
	{
		return [
				'symbol' => 'required|string|exists:historical_data,symbol',
				'shares' => 'required|numeric|min:0|max:999999.99999',
		];
	}
}
