<?php

namespace App\Http\Controllers;

use App\Services\ToDoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ToDoController extends Controller
{
    public function index(): JsonResponse
    {
        return Response::json([
            'data' => ToDoService::getAll(),
            'message' => 'ToDos retrieved successfully'
        ])->setStatusCode(200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(['title' => 'required']);
        return Response::json([
            'data'      => ToDoService::insert($request->title),
            'message'   => 'Todo created successfully'
        ])->setStatusCode(201);
    }

    public function destroy(string $id)
    {
        ToDoService::delete($id);
        return Response::json([
            'data' => [],
            'message' => 'ToDo deleted successfully'
        ])->setStatusCode(200);
    }
}
