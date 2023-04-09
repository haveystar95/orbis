<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Portfolio
 *
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Portfolio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Portfolio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Portfolio query()
 * @mixin \Eloquent
 */
class Portfolio extends Model
{
	use HasFactory;
	
	protected $fillable = [
			'user_id',
			'symbol',
			'shares',
	];
	
	protected $casts = [
			'user_id' => 'integer',
			'shares' => 'float',
	];
	
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}