<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\studentController;

Route::get('/estudiantes', [studentController::class, 'index']);

Route::get('/estudiantes/{id}', [studentController::class, 'show']);

Route::post('/estudiantes', [studentController::class, 'store']);

Route::put('/estudiantes/{id}', function() {
    return 'Actualizando estudiante';
});

Route::delete('/estudiantes/{id}', function() {
    return 'Eliminando Estudiante';
});
