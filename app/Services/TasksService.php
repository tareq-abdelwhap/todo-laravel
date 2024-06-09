<?php

namespace App\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class TasksService
{
    private static function baseQuery(int|string|null $id = null, int|string|null $list_id = null): Builder
    {
        return DB::table('tasks')
            ->select('id', 'name', 'is_completed', 'updated_at')
            ->when($list_id, fn($query) => $query->where('list_id', $list_id))
            ->when($id, fn($query) => $query->where('id', $id));
    }

    public static function getAll($list_id): array
    {
        return self::baseQuery(list_id: $list_id)->get()->toArray();
    }

    public static function insert($list_id, string $name)
    {
        $id = self::baseQuery()->insertGetId([
            'name' => $name,
            'list_id' => $list_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return self::baseQuery(id: $id)->first(['id', 'name', 'is_completed', 'updated_at']);
    }

    public static function toggle(string $id, bool $is_completed)
    {
        self::baseQuery(id: $id)
            ->update([
                'is_completed'  => $is_completed,
                'updated_at'    => now()
            ]);
        return self::baseQuery(id: $id)->first(['id', 'name', 'is_completed', 'updated_at']);
    }

    public static function delete(string $id)
    {
        self::baseQuery(id: $id)->delete();
    }
}
