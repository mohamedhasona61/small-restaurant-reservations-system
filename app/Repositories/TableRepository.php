<?php

namespace App\Repositories;

use App\Models\Table;
use App\Interfaces\TableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TableRepository implements TableRepositoryInterface
{
    public function all(): Collection
    {
        return Table::all();
    }
    public function find(int $id): ?object
    {
        return Table::find($id);
    }
    public function create(array $data): object
    {
        return Table::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $table = Table::find($id);
        return $table ? $table->update($data) : false;
    }
    public function delete(int $id): bool
    {
        return Table::destroy($id);
    }
    public function availableTables(string $date, string $time, int $guests): Collection
    {
        return Table::where('is_active', true)
            ->where('capacity', '>=', $guests)
            ->withCount(['reservations' => function ($query) use ($date, $time) {
                $query->where('reservation_date', $date)
                    ->where('reservation_time', $time)
                    ->whereIn('status', ['confirmed', 'pending']);
            }])
            ->having('reservations_count', 0)
            ->get();
    }
    public function allWithTrashed(): Collection
    {
        return Table::withTrashed()->get();
    }
    public function findWithTrashed(int $id): ?object
    {
        return Table::withTrashed()->find($id);
    }
    public function restore(int $id): bool
    {
        $table = Table::withTrashed()->find($id);
        return $table ? $table->restore() : false;
    }
}
