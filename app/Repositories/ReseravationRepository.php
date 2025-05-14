<?php

namespace App\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\Table;
use App\Models\MenuItem;
use App\Models\Reservation;
use App\Models\ReservationItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ExceptionHandler;
use Illuminate\Validation\ValidationException;
use App\Interfaces\ReservationRepositoryInterface;

class ReseravationRepository implements ReservationRepositoryInterface
{
    public function createReservation(array $data): Reservation
    {
        return DB::transaction(function () use ($data) {
                $this->validateTable($data['table_id'], $data['guest_count']);
                $reservation = $this->createReservationRecord($data);
                $this->processReservationItems($reservation, $data['items'], $data['reservation_date']);
                return $reservation->load(['items.menuItem', 'table']);
        });
    }

    protected function validateTable(int $tableId, int $guestCount): Table
    {
        $table = Table::active()->find($tableId);

        if (!$table) {
            throw new \Exception('Selected table is invalid or inactive.', 400);
        }

        if ($guestCount > $table->capacity) {
            throw new \Exception("Guest count cannot exceed table capacity of {$table->capacity}.", 400);
        }
        return $table;
    }

    protected function validateMenuItemAvailability(MenuItem $menuItem, int $quantity, Carbon $reservationDate): void
    {
        $reservedQty = ReservationItem::where('menu_item_id', $menuItem->id)
            ->whereHas(
                'reservation',
                fn($q) =>
                $q->whereDate('reservation_date', $reservationDate)
            )->sum('quantity');

        $availableQty = $menuItem->daily_availability - $reservedQty;
        if ($quantity > $availableQty) {
            throw new \Exception(
                "Only {$availableQty} item(s) available for {$menuItem->name} on {$reservationDate->toDateString()}",
                400
            );
        }
    }

    protected function createReservationRecord(array $data): Reservation
    {
        return Reservation::create([
            'table_id' => $data['table_id'],
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'reservation_date' => $data['reservation_date'],
            'reservation_time' => $data['reservation_time'],
            'guest_count' => $data['guest_count'],
            'special_requests' => $data['special_requests'] ?? null,
        ]);
    }

    protected function processReservationItems(Reservation $reservation, array $items, string $reservationDate): void
    {
        $reservationDate = Carbon::parse($reservationDate);

        foreach ($items as $item) {
            $menuItem = MenuItem::findOrFail($item['menu_item_id']);

            $this->validateMenuItemAvailability($menuItem, $item['quantity'], $reservationDate);

            $pricing = $this->calculateItemPricing($menuItem);

            $reservation->items()->create([
                'menu_item_id' => $menuItem->id,
                'quantity' => $item['quantity'],
                'price_before_discount' => $pricing['price'],
                'price_after_discount' => $pricing['price_after_discount'],
                'price_at_reservation' => $pricing['price_after_discount'],
                'discount_amount' => $pricing['discount_amount'],
                'discount_type' => $pricing['discount_type'],
            ]);
        }
    }



    protected function calculateItemPricing(MenuItem $menuItem): array
    {
        $now = Carbon::now();
        $price = $menuItem->price;
        $isDiscountActive = $menuItem->discount_start_at &&
            $menuItem->discount_end_at &&
            $now->between($menuItem->discount_start_at, $menuItem->discount_end_at);
        $discountAmount = $isDiscountActive ? $menuItem->discount_amount : 0;
        $discountType = $isDiscountActive ? $menuItem->discount_type : 'fixed';
        $priceAfterDiscount = match ($discountType) {
            'percentage' => $price - ($price * $discountAmount / 100),
            'fixed' => $price - $discountAmount,
            default => $price
        };
        return [
            'price' => $price,
            'price_after_discount' => $priceAfterDiscount,
            'discount_amount' => $discountAmount,
            'discount_type' => $discountType,
        ];
    }
    public function findById(int $id): ?Reservation
    {
        return Reservation::with(['items.menuItem', 'table'])->find($id);
    }

    public function getReservationsForTable(int $tableId, string $date, string $time): array
    {
        return Reservation::with(['items.menuItem'])
            ->where('table_id', $tableId)
            ->where('reservation_date', $date)
            ->where('reservation_time', $time)
            ->whereIn('status', ['confirmed', 'completed'])
            ->get()
            ->toArray();
    }
}
