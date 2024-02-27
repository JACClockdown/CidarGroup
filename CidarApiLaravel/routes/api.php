<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StudentsController;
use App\Http\Controllers\API\HomeworksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['jwt']], function(){
    Route::get('students', [StudentsController::class, 'index'])->name('students.index');
    Route::post('student/store', [StudentsController::class, 'store'])->name('students.store');
    Route::put('student/update/{id}', [StudentsController::class, 'update'])->name('students.update');
    Route::delete('student/delete/{id}', [StudentsController::class, 'destroy'])->name('students.delete');

    Route::get('homeworks', [HomeworksController::class, 'index'])->name('homeworks.index');
    Route::post('homework/store', [HomeworksController::class, 'store'])->name('homeworks.store');
    Route::put('homework/update/{id}', [HomeworksController::class, 'update'])->name('homeworks.update');
    Route::delete('homework/delete/{id}', [HomeworksController::class, 'destroy'])->name('homeworks.delete');
});
