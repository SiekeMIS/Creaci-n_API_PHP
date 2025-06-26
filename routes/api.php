<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\libroController;

Route::get('/libros', [libroController::class, 'index']);

Route::get('/libros/{id}', [libroController::class, 'show']);

Route::post('/libros', [libroController::class, 'store']);

Route::put('/libros/{id}', [libroController::class, 'update']);

Route::patch('/libros/{id}', [libroController::class, 'updatePartial']);

Route::delete('/libros/{id}', [libroController::class, 'delete']);