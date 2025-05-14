<?php

namespace App\Interfaces;

interface MenuRepositoryInterface
{
    public function getAllMenuItems();
    public function getAvailableMenuItems();
    public function getMenuItemById($menuItemId);
    public function deleteMenuItem($menuItemId);
    public function createMenuItem(array $menuItemDetails);
    public function updateMenuItem($menuItemId, array $newDetails);
    public function decrementAvailability($menuItemId, $quantity = 1);
    public function resetDailyAvailability();
}