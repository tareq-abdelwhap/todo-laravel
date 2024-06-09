<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('todos', 'App\Http\Controllers\ToDoController')->except('show', 'update');
Route::apiResource('tasks', 'App\Http\Controllers\TaskController')->except('show');
