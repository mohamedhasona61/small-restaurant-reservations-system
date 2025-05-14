<?php
namespace App\Interfaces;

use App\Models\Reservation;

interface ReservationRepositoryInterface
{
    public function createReservation(array $data): Reservation;
    public function findById(int $id): ?Reservation;
    public function getReservationsForTable(int $tableId, string $date, string $time): array;

    
}
