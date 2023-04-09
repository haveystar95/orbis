<?php

namespace App\Console\Commands;

use App\Models\HistoricalData;
use App\Repositories\HistoricalDataRepository\HistoricalDataRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Throwable;

class ImportHistoricalData extends Command
{
	protected $signature = 'import:historical-data {file}';
	protected $description = 'Import historical data from a CSV file';
	
	protected HistoricalDataRepositoryInterface $historicalDataRepository;
	
	public function __construct(HistoricalDataRepositoryInterface $historicalDataRepository)
	{
		parent::__construct();
		$this->historicalDataRepository = $historicalDataRepository;
	}
	
	/**
	 * @throws Throwable
	 */
	public function handle(): int
	{
		$filePath = $this->argument('file');
		
		if (!file_exists($filePath) || !is_readable($filePath)) {
			$this->error('The provided file path is not valid or not readable.');
			return 1;
		}
		
		
		$csv = Reader::createFromPath($filePath, 'r');
		$csv->setHeaderOffset(0);
		
		$records = $csv->getRecords();
		
		DB::beginTransaction();
		
		try {
			foreach ($records as $record) {
				$historicalItem = new HistoricalData();
				$historicalItem->fill($record);
				$this->historicalDataRepository->save($historicalItem);
			}
			
			DB::commit();
		} catch (Throwable $e) {
			DB::rollback();
			throw $e;
		}
		
		$this->info('Historical data imported successfully.');
		
		return 0;
	}
}
