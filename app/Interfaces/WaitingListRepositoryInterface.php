<?php
namespace App\Interfaces;

use App\Models\WaitingList;

interface WaitingListRepositoryInterface
{
    public function addToWaitingList(array $data): WaitingList;
    public function getPendingEntries(string $date, string $time): array;
    public function markAsNotified(int $id): void;
}
