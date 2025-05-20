<?php

namespace App\Repositories;

use App\Models\WaitingList;
use App\Interfaces\WaitingListRepositoryInterface;

class WaitingListRepository implements WaitingListRepositoryInterface
{
    public function create(array $data): WaitingList
    {
        return WaitingList::create($data);
    }
}
