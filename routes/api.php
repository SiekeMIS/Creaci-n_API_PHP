<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\libroController;

Route::get('/libros', [libroController::class, 'index']);

Route::get('/libros/{id}', function (){
    return 'Obteniendo Un Libro';
});

Route::post('/libros', function (){
    return 'Creando libros';
});

Route::put('/libros/{id}', function (){
    return 'Actualizando Libros';
});

Route::delete('/libros/{id}', function (){
    return 'Eliminando Libros';
});