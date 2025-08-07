<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentImportController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware(['auth', 'verified'])->group(function() {
    // Route::prefix('admin')->group(function() {
    //     Route::get('/students/import', [StudentImportController::class, 'showImportForm'])
    //         ->name('students.import');
    //     Route::post('/students/import', [StudentImportController::class, 'import'])
    //         ->name('students.import.submit');
    // });
// });

// routes/web.php
// Route::post('/debug-import', function(Request $request) {
//     $request->validate(['file' => 'required|file']);
    
//     try {
//         Excel::import(new \App\Imports\StudentsImport, $request->file('file'));
//         return back()->with('debug', 'Debug completed - check logs');
//     } catch (\Exception $e) {
//         return back()->with('error', 'Debug failed: '.$e->getMessage());
//     }
// });


// Authentication routes
// Route::prefix('student')->group(function () {
    Route::get('/', [StudentController::class, 'showLoginForm'])->name('student.login.form');
    Route::post('/login', [StudentController::class, 'login'])->name('student.login');
// });

// Protected student routes
Route::middleware(['student.auth'])->prefix('student')->group(function () {
    Route::get('/logout', [StudentController::class, 'logout'])->name('student.logout');
    Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    Route::post('/get-meal-rates', [StudentController::class, 'get_meal_rates'])->name('student.get_meal_rates');
    Route::post('/student/subscribe', [StudentController::class, 'subscribe'])->name('student.subscribe');
    Route::get('/student/meal-voucher/{uid}', [StudentController::class, 'showVoucher'])
    ->middleware('auth:student')
    ->name('student.meal-voucher');
     Route::get('/voucher/{uid}', [StudentController::class, 'generateVoucher'])->name('student.meal-voucher');
     Route::get('/subscriptions', [StudentController::class, 'subscriptions'])->name('student.subscription');
});

// routes/web.php
Route::prefix('admin')->group(function () {
        Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AdminController::class, 'login']);

        Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/students/status-toggle/{id}', [AdminController::class, 'toggleStatus']);
        Route::delete('/students/delete/{id}', [AdminController::class, 'delete'])->name('student.delete');
        Route::get('/students/edit/{id}', [AdminController::class, 'edit'])->name('admin.students.edit');
        Route::post('/students/update/{id}', [AdminController::class, 'Update'])->name('admin.students.update');
        Route::get('/students/import', [StudentImportController::class, 'showImportForm'])->name('students.import');
        Route::post('/students/import', [StudentImportController::class, 'import'])->name('students.import.submit');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout'); 
        Route::get('/meals', [AdminController::class, 'students_meals'])->name('admin.students.meals'); 
   
    });
});

