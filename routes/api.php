<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('Login', [AuthController::class, 'Login']);

Route::get('admin/expenses/{record}/edit', [ExpenseController::class, 'edit'])->name('filament.admin.resources.expenses.edit');



