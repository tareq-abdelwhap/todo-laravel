<?php

namespace App\Http\Controllers;

use App\Services\TasksService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return Response::json([
            'data' => TasksService::getAll($request->list_id),
            'message' => 'Tasks retrieved successfully'
        ])->setStatusCode(200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(['name' => 'required']);
        return Response::json([
            'data'      => TasksService::insert($request->list_id, $request->name),
            'message'   => 'Task created successfully'
        ])->setStatusCode(201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate(['is_completed'  => 'required|boolean']);
        return Response::json([
            'data' => TasksService::toggle($id, $request->is_completed),
            'message' => 'Task updated successfully'
        ])->setStatusCode(200);
    }

    public function destroy(string $id): JsonResponse
    {
        TasksService::delete($id);
        return Response::json([
            'data' => [],
            'message' => 'Task deleted successfully'
        ])->setStatusCode(200);
    }
}
