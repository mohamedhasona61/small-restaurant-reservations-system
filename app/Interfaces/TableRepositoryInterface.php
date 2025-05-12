<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface TableRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?object;
    public function create(array $data): object;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function availableTables(string $date, string $time, int $guests): Collection;
    public function allWithTrashed(): Collection;
    public function findWithTrashed(int $id): ?object;
    public function restore(int $id): bool;
}
