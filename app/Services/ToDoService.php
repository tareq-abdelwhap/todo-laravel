<?php

namespace App\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ToDoService
{
    private static function baseQuery(int|string|null $id = null): Builder
    {
        return DB::table('lists')
            ->select('id', 'title', 'updated_at')
            ->when($id, fn($query) => $query->where('id', $id));
    }

    public static function getAll(): array
    {
        return self::baseQuery()->get()->toArray();
    }

    public static function insert(string $title)
    {
        $id = self::baseQuery()->insertGetId([
            'title' => $title,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return self::baseQuery($id)->first(['id', 'title', 'updated_at']);
    }


    public static function delete(string $id)
    {
        self::baseQuery($id)->delete();
    }
}
