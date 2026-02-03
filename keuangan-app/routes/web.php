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

// masuk dahboard harus login dan terverifikasi dulu
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    // halaman utama
Route::get('/', function () {
    return view('welcome');
});

// register with admin
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/register', [RegisteredUserController::class, 'create'])
        ->name('admin.register');

    Route::post('/admin/register', [RegisteredUserController::class, 'store'])
        ->name('admin.register.store');
});

Route::middleware('auth')->prefix('settings')->name('settings.')->group(function () {

    Route::get('/profile', function () {
        return view('settings.profile');
    })->name('profile');

    Route::get('/account', function () {
        return view('settings.account');
    })->name('account');

    Route::get('/security', function () {
        return view('settings.security');
    })->name('security');

});





// Hanya Admin yang bisa CRUD transaksi
Route::middleware(['auth', 'role:admin'])->group(function () { //group itu mengelompokkan function dan memberikan aturan yang sama
    Route::resource('transactions', TransactionController::class);
});

// Transactions - Pemasukan
// prefix agar URL sesuai kode
Route::prefix('transactions/pemasukan')->middleware('auth')->group(function () { 
    Route::get('/', [TransactionController::class, 'pemasukan'])->name('pemasukan.index');
    Route::get('/create', [TransactionController::class, 'createPemasukan'])->name('pemasukan.create');
    Route::get('/{id}/edit', [TransactionController::class, 'editPemasukan'])->name('pemasukan.edit');
});

// Transactions - Pengeluaran
Route::prefix('transactions/pengeluaran')->middleware('auth')->group(function () {
    Route::get('/', [TransactionController::class, 'pengeluaran'])->name('pengeluaran.index');
    Route::get('/create', [TransactionController::class, 'createPengeluaran'])->name('pengeluaran.create');
    Route::get('/{id}/edit', [TransactionController::class, 'editPengeluaran'])->name('pengeluaran.edit'); // edit berdasarkan ID
});

// route hanya bisa jika login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Resource utama / Master data
Route::middleware(['auth'])->group(function () {
    Route::resource('types', TypeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('sub-categories', SubCategoryController::class);
    Route::resource('transactions', TransactionController::class);
});

// ambil data sub categories lewat categories
Route::get('/get-subcategories/{category_id}', [SubCategoryController::class, 'getByCategory'])
    ->middleware('auth')
    ->name('subcategories.byCategory');

    // membuat laporan
Route::middleware(['auth'])->group(function () {
    Route::get('/report/generate', [ReportController::class, 'generate'])->name('report.generate');
});


// generate laporan pdf index
Route::get('/report/transactions', [ReportIndexController::class, 'generate']) //catatan nanti pakai auth
    ->name('report.index.generate');


require __DIR__.'/auth.php';
