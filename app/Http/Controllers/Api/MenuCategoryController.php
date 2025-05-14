<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MenuCategoryRequest;
use App\Http\Resources\Api\MenuCategoryResource;
use App\Interfaces\MenuCategoryRepositoryInterface;

class MenuCategoryController extends Controller
{
    use ApiResponse;
    private MenuCategoryRepositoryInterface $repository;
    public function __construct(MenuCategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index(): JsonResponse
    {
        try {
            $categories = $this->repository->all();
            return $this->successResponse(200, 'Successfully retrieved all menu categories',  MenuCategoryResource::collection($categories));
        } catch (\Exception $e) {
            return $this->errorResponse(500, 'Failed to retrieve menu categories: ' . $e->getMessage());
        }
    }
    public function store(MenuCategoryRequest $request): JsonResponse
    {
        try {
            $category = $this->repository->create($request->validated());
            return $this->successResponse(201, 'Menu category created successfully', new MenuCategoryResource($category));
        } catch (\Exception $e) {
            return $this->errorResponse(500, 'Failed to create menu category: ' . $e->getMessage());
        }
    }
    public function show(int $id): JsonResponse
    {
        try {
            $category = $this->repository->find($id);
            if (!$category) {
                return $this->errorResponse(404, 'Menu category not found');
            }
            return $this->successResponse(200, 'Successfully retrieved menu category', $category);
        } catch (\Exception $e) {
            return $this->errorResponse(500, 'Failed to retrieve menu category: ' . $e->getMessage());
        }
    }
    public function update(MenuCategoryRequest $request, int $id): JsonResponse
    {
        try {
            $success = $this->repository->update($id, $request->validated());
            if (!$success) {
                return $this->errorResponse(404, 'Menu category not found');
            }
            $updatedCategory = $this->repository->find($id);
            return $this->successResponse(200, 'Menu category updated successfully', $updatedCategory);
        } catch (\Exception $e) {
            return $this->errorResponse(500, 'Failed to update menu category: ' . $e->getMessage());
        }
    }
    public function destroy(int $id): JsonResponse
    {
        try {
            $success = $this->repository->delete($id);
            if (!$success) {
                return $this->errorResponse(404, 'Menu category not found');
            }
            return $this->successResponse(200, 'Menu category deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse(500, 'Failed to delete menu category: ' . $e->getMessage());
        }
    }
}
