<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\InertiaTestContoroller;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AnalysisController;

Route::get('analysis', [AnalysisController::class, 'index'])->name('analysis');

Route::resource('items', ItemController::class)
->middleware(['auth','verified']);

Route::resource('customers', CustomerController::class)
->middleware(['auth','verified']);

Route::resource('purchases', purchaseController::class)
->middleware(['auth','verified']);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/inertia-test', function(){
    return Inertia::render('InertiaTest');
}
);

Route::get('/component-test', function(){
    return Inertia::render('ComponentTest');
}
);

Route::get('/app', function(){
    return Inertia::render('App');
}
);



Route::get('/inertia/index', [InertiaTestContoroller::class, 'index'])->name('inertia.index');
Route::get('/inertia/create', [InertiaTestContoroller::class, 'create'])->name('inertia.create');
Route::post('/inertia', [InertiaTestContoroller::class, 'store'])->name('inertia.store');
Route::get('/inertia/show/{id}', [InertiaTestContoroller::class, 'show'])->name('inertia.show');
Route::delete('/inertia/{id}', [InertiaTestContoroller::class, 'delete'])->name('inertia.delete');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
