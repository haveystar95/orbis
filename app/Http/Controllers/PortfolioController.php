<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioRequest;
use App\Http\Requests\PortfolioValueRequest;
use App\Services\PortfolioService\PortfolioDTO;
use App\Services\PortfolioService\PortfolioServiceInterface;
use Illuminate\Http\JsonResponse;

class PortfolioController extends Controller
{
	protected PortfolioServiceInterface $portfolioService;
	
	public function __construct(PortfolioServiceInterface $portfolioService)
	{
		$this->portfolioService = $portfolioService;
	}
	
	public function index(): JsonResponse
	{
		$portfolioCollection = $this->portfolioService->list(auth()->user());
		
		return response()->json($portfolioCollection, 200);
	}
	
	public function store(PortfolioRequest $request): JsonResponse
	{
		$dto = PortfolioDTO::fromRequest($request->validated());
		
		$portfolio = $this->portfolioService->create(auth()->user(), $dto);
		
		return response()->json($portfolio, 201);
	}
	
	public function update(PortfolioRequest $request, int $id): JsonResponse
	{
		$dto = PortfolioDTO::fromRequest($request->validated());
		$portfolio = $this->portfolioService->update(auth()->user(), $id, $dto);
		
		return response()->json($portfolio, 200);
	}
	
	public function getValue(PortfolioValueRequest $request): JsonResponse
	{
		$date = $request->get('date');
		$symbol = $request->get('symbol');
		$portfolioValue = $this->portfolioService->getValue(auth()->user(), $symbol, $date);
		
		return response()->json($portfolioValue, 200);
	}
}