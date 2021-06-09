<?php

use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\DailyQuotesController;
use App\Http\Controllers\EmployeesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::resource('companies', CompaniesController::class);
    Route::resource('employees', EmployeesController::class);
    Route::get('filter-employee', [EmployeesController::class, 'filter_employee']);
    Route::resource('daily-quotes', DailyQuotesController::class);
});
