<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HistoricalData
 *
 * @property int $id
 * @property string $symbol
 * @property string $date
 * @property float $open
 * @property float $high
 * @property float $low
 * @property float $close
 * @property int $volume
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricalData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricalData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricalData query()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricalData whereClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricalData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricalData whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricalData whereHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricalData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricalData whereLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricalData whereOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricalData whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricalData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricalData whereVolume($value)
 * @mixin \Eloquent
 */
class HistoricalData extends Model
{
	use HasFactory;
	
	protected $fillable = [
			'symbol',
			'date',
			'open',
			'high',
			'low',
			'close',
			'volume',
	];
	
	protected array $dates = [
			'date',
	];
	
	protected $casts = [
			'open' => 'float',
			'high' => 'float',
			'low' => 'float',
			'close' => 'float',
			'volume' => 'integer',
	];
}
