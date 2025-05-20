<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreWaitingListRequest;
use App\Interfaces\WaitingListRepositoryInterface;

class WaitingListController extends Controller
{
    use ApiResponse;
    private WaitingListRepositoryInterface $waitingListRepo;
    public function __construct(WaitingListRepositoryInterface $waitingListRepo)
    {
        $this->waitingListRepo = $waitingListRepo;
    }
    public function CreateWaitingList(StoreWaitingListRequest $request)
    {
        $waitingList = $this->waitingListRepo->create($request->validated());
        return response()->json(['data' => $waitingList], 201);
    }
}
