<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	
	public function up(): void
	{
		Schema::create('historical_data', static function (Blueprint $table) {
			$table->id();
			$table->string('symbol');
			$table->date('date');
			$table->decimal('open', 15, 2);
			$table->decimal('high', 15, 2);
			$table->decimal('low', 15, 2);
			$table->decimal('close', 15, 2);
			$table->unsignedBigInteger('volume');
			$table->timestamps();
			
			$table->unique(['symbol', 'date']);
		});
	}
	
	
	public function down(): void
	{
		Schema::dropIfExists('historical_data');
	}
};
