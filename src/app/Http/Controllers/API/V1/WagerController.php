<?php

namespace App\Http\Controllers\API\V1;

use App\Services\WagerService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Wager\StoreRequest;
use App\Http\Requests\Wager\BuyRequest;
use Exception;
use App\Http\Resources\Wager\WagerResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WagerController extends Controller
{
    private $wagerService;

    public function __construct(
        WagerService $wagerService)
    {
        $this->wagerService = $wagerService;
    }

    /**
     * Store a wager resource in storage.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $result = $this->wagerService->store($request->validate());
        return response()->json($result, 201);
    }

    /**
     * Buy wager.
     *
     * @param BuyRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function buy(BuyRequest $request, int $id): JsonResponse
    {
        $result = $this->wagerService->buy($request->validate(), $id);
        return response()->json($result, 201);
    }

    /**
     * Show list of wagers.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $resource = $this->wagerService->show($request->all());
        return response()->json(WagerResource::collection($resource), 200);
    }
}

