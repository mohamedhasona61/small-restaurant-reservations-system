<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreTableRequest;
use App\Interfaces\TableRepositoryInterface;
use App\Http\Requests\Api\UpdateTableRequest;
use App\Http\Requests\Api\CheckAvailabilityRequest;

class TableController extends Controller
{
    use ApiResponse;
    private TableRepositoryInterface $tableRepository;
    public function __construct(TableRepositoryInterface $tableRepository)
    {
        $this->tableRepository = $tableRepository;
    }
    public function index(): JsonResponse
    {
        $tables = $this->tableRepository->all();
        return $this->successResponse(200, 'Tables retrieved successfully', $tables);
    }
    public function store(StoreTableRequest $request): JsonResponse
    {
        $table = $this->tableRepository->create($request->validated());
        return $this->successResponse(201, 'Table created successfully', $table);
    }
    public function update(UpdateTableRequest $request, int $id): JsonResponse
    {
        $this->tableRepository->update($id, $request->validated());
        return $this->successResponse(200, 'Table updated successfully', $this->tableRepository->find($id));
    }
    public function destroy(int $id): JsonResponse
    {
        $this->tableRepository->delete($id);
        return $this->successResponse(204, 'Table deleted successfully');
    }
    public function checkAvailability(CheckAvailabilityRequest $request): JsonResponse
    {
        $data = $request->validated();
        $availableTables = $this->tableRepository->availableTables($data['date'], $data['time'], $data['guests']);
        return $this->successResponse(200, 'Available tables retrieved', $availableTables);
    }
    public function restore(int $id): JsonResponse
    {
        $this->tableRepository->restore($id);
        return $this->successResponse(200, ' Table restored successfully', $this->tableRepository->findWithTrashed($id));
    }
}