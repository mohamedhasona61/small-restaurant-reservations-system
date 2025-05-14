<?php

namespace App\Repositories;

use App\Models\MenuItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Traits\HandlesMediaUploads;
use App\Http\Resources\Api\MenuResource;
use App\Interfaces\MenuRepositoryInterface;

class MenuRepository implements MenuRepositoryInterface
{
    use HandlesMediaUploads;
    public function getAllMenuItems()
    {
        return MenuResource::collection(
            MenuItem::with(['menu_category'])
                ->whereHas('menu_category', function ($query) {
                    $query->where('is_active', 1);
                })
                ->get()
        );
    }
    public function getAvailableMenuItems()
    {
        $categoryId = request()->input('category_id');
        $query = MenuItem::with(['menu_category'])
            ->whereHas('menu_category', function ($q) {
                $q->where('is_active', 1);
            })
            ->available();
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        return $query->get();
    }
    public function getMenuItemById($menuItemId)
    {
        return MenuItem::with(['menu_category'])->findOrFail($menuItemId);
    }
    public function deleteMenuItem($menuItemId)
    {
        MenuItem::destroy($menuItemId);
    }
    public function createMenuItem(array $data)
    {
        return DB::transaction(function () use ($data) {
            $menuItemDetails = Arr::except($data, ['images']);
            $menuItem = MenuItem::create($menuItemDetails);
            if (isset($data['images']) && is_array($data['images'])) {
                $this->handleMediaUpload($menuItem, $data['images'], 'menu_images');
            }
            return $menuItem->load(['menu_category' => function ($query) {
                $query->withoutGlobalScopes();
            }]);
        });
    }

    /**
     * Update menu item details
     */
    public function updateMenuItem($menuItemId, array $newDetails)
    {
        MenuItem::whereId($menuItemId)->update($newDetails);

        // Return the updated item with relationship
        return $this->getMenuItemById($menuItemId);
    }

    /**
     * Decrement availability of a menu item
     */
    public function decrementAvailability($menuItemId, $quantity = 1)
    {
        $menuItem = MenuItem::findOrFail($menuItemId);
        $menuItem->current_availability = max(0, $menuItem->current_availability - $quantity);
        $menuItem->save();

        return $menuItem->load(['menu_category' => function ($query) {
            $query->withoutGlobalScopes();
        }]);
    }

    /**
     * Reset daily availability for all menu items
     */
    public function resetDailyAvailability()
    {
        MenuItem::query()->update(['current_availability' => DB::raw('daily_availability')]);
    }
}
