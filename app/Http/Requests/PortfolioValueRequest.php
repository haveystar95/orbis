<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioValueRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}
	
	public function rules(): array
	{
		return [
				'date' => 'date|date_format:d-m-Y|before:tomorrow',
				'symbol' => 'string|exists:historical_data,symbol',
		];
	}
}
