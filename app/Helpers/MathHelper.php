<?php

namespace App\Helpers;

class MathHelper
{
	public static function roundFloatShares($value, $precision = 5): float
	{
		return round($value, $precision);
	}
	
	public static function roundPercentage($value, $precision = 2): float
	{
		return round($value, $precision);
	}
	
	public static function getChangePercentage(float $value1, float $value2): float
	{
		return ($value1 / $value2) * 100;
	}
}
