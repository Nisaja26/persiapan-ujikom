<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportIndexController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Register User
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/register', [RegisteredUserController::class, 'create'])
        ->name('admin.register');

    Route::post('/admin/register', [RegisteredUserController::class, 'store'])
        ->name('admin.register.store');
});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Master Data
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::resource('types', TypeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('sub-categories', SubCategoryController::class);

});

Route::get('/get-subcategories/{id}', 
    [SubCategoryController::class, 'getByCategory']
);

/*
|--------------------------------------------------------------------------
| Transactions (Admin Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('transactions', TransactionController::class);
});

/*
|--------------------------------------------------------------------------
| Transactions Custom Views
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('transactions')->group(function () {

    Route::prefix('pemasukan')->group(function () {
        Route::get('/', [TransactionController::class, 'pemasukan'])->name('pemasukan.index');
        Route::get('/create', [TransactionController::class, 'createPemasukan'])->name('pemasukan.create');
        Route::get('/{id}/edit', [TransactionController::class, 'editPemasukan'])->name('pemasukan.edit');
    });

    Route::prefix('pengeluaran')->group(function () {
        Route::get('/', [TransactionController::class, 'pengeluaran'])->name('pengeluaran.index');
        Route::get('/create', [TransactionController::class, 'createPengeluaran'])->name('pengeluaran.create');
        Route::get('/{id}/edit', [TransactionController::class, 'editPengeluaran'])->name('pengeluaran.edit');
    });

});

/*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/report/generate', [ReportController::class, 'generate'])->name('report.generate');
    Route::get('/report/transactions', [ReportIndexController::class, 'generate'])
        ->name('report.index.generate');
});


/*
|--------------------------------------------------------------------------
| Users (Admin Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

/*
|--------------------------------------------------------------------------
| Roles (Admin Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});

/*
|--------------------------------------------------------------------------
| Auth routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
