<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface MenuCategoryRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?object;
    public function create(array $data): object;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}