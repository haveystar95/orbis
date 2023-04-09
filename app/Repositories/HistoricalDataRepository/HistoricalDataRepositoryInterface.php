<?php

namespace App\Repositories\HistoricalDataRepository;

use App\Models\HistoricalData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

interface HistoricalDataRepositoryInterface
{
	public function save(HistoricalData $historicalData): HistoricalData;
	
	public function getHistoricalDataBySymbols(array $symbols, ?Carbon $date = null): ?Collection;
}