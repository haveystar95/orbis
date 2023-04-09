<?php

namespace App\Repositories\HistoricalDataRepository;

use App\Models\HistoricalData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class HistoricalDataRepository implements HistoricalDataRepositoryInterface
{
	public function save(HistoricalData $historicalData): HistoricalData
	{
		return HistoricalData::updateOrCreate(
				[
						'symbol' => $historicalData->symbol,
						'date' => $historicalData->date,
				],
				[
						'open' => $historicalData->open,
						'high' => $historicalData->high,
						'low' => $historicalData->low,
						'close' => $historicalData->close,
						'volume' => $historicalData->volume,
				]
		);
	}
	
	public function getHistoricalDataBySymbols(array $symbols, ?Carbon $date = null): Collection
	{
		$query = HistoricalData::whereIn('symbol', $symbols);
		
		if ($date) {
			$checkDate = HistoricalData::whereIn('symbol', $symbols)->whereDate('date', '=', $date);
			if ($checkDate->exists()) {
				$query->whereDate('date', '<=', $date);
			}
		}
		
		return $query
				->orderBy('date', 'desc')
				->get()
				->groupBy('symbol')
				->map(function ($data) {
					$currentData = $data->first();
					$initialData = $data->last();
					$currentData->initial_close = $initialData ? $initialData->close : $currentData->close;
					return $currentData;
				});
	}
}