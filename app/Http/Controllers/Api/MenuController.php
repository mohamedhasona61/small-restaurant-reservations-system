<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Exceptions\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MenuRequest;
use App\Http\Resources\Api\MenuResource;
use App\Interfaces\MenuRepositoryInterface;

class MenuController extends Controller
{
    use ApiResponse;
    private MenuRepositoryInterface $repository;
    public function __construct(MenuRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index(): JsonResponse
    {
        try {
            $menuItems = $this->repository->getAllMenuItems();
            return $this->successResponse(200, 'Successfully retrieved all menu Item',  MenuResource::collection($menuItems));
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e, request(), 'Failed to retrieve menu Item');
        }
    }
    public function store(MenuRequest $request): JsonResponse
    {
        try {
            $menuItem = $this->repository->createMenuItem($request->validated());

            return $this->successResponse(201, 'Menu category created successfully', new MenuResource($menuItem));
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e, request(), 'Failed to retrieve menu Item');
        }
    }
    public function show(int $id): JsonResponse
    {
        try {
            $menuItem = $this->repository->getMenuItemById($id);
            if (!$menuItem) {
                return $this->errorResponse(404, 'Menu Item not found');
            }
            return $this->successResponse(200, 'Successfully retrieved menu', $menuItem);
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e, request(), 'Failed to retrieve menu item');
        }
    }
    public function update(MenuRequest $request, int $id): JsonResponse
    {
        try {
            $success = $this->repository->updateMenuItem($id, $request->validated());
            if (!$success) {
                return $this->errorResponse(404, 'Menu category not found');
            }
            $updatedCategory = $this->repository->getMenuItemById($id);
            return $this->successResponse(200, 'Menu category updated successfully', $updatedCategory);
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e, request(), 'Failed to retrieve menu categories');
        }
    }
    public function destroy(int $id): JsonResponse
    {
        try {
            $success = $this->repository->deleteMenuItem($id);
            if (!$success) {
                return $this->errorResponse(404, 'Menu category not found');
            }
            return $this->successResponse(200, 'Menu category deleted successfully');
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e, request(), 'Failed to retrieve menu categories');
        }
    }

    public function getAvailableMenuItems(int $id): JsonResponse
    {
        try {
            $this->repository->getAvailableMenuItems();
            return $this->successResponse(200, 'available menu items retreivs successfully');
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e, request(), 'Failed to retrieve available menu items');
        }
    }
    
}
