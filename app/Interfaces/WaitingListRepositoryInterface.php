<?php
namespace App\Interfaces;

use App\Models\WaitingList;

interface WaitingListRepositoryInterface
{
    public function create(array $data): WaitingList;
}
