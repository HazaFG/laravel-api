<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\studentController;

Route::get('/', function () {
    return redirect()->route('estudiantes.index');
});

// Rutas para Estudiantes en Blade, ni modo la otra api del principio jaja
Route::get('/estudiantes', [studentController::class, 'index'])->name('estudiantes.index');
Route::get('/estudiantes/crear', [studentController::class, 'create'])->name('estudiantes.create');
Route::post('/estudiantes', [studentController::class, 'store'])->name('estudiantes.store');
Route::get('/estudiantes/{id}/editar', [studentController::class, 'edit'])->name('estudiantes.edit');
Route::put('/estudiantes/{id}', [studentController::class, 'update'])->name('estudiantes.update');
Route::delete('/estudiantes/{id}', [studentController::class, 'destroy'])->name('estudiantes.destroy');
