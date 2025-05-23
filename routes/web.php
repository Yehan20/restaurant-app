<?php

use App\Http\Controllers\ConcessionController;
use App\Http\Controllers\KitchenOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Route::middleware('auth')->group(function () {

    Route::resource('concessions', ConcessionController::class);

    Route::resource('orders', OrderController::class)->except('show');
    Route::prefix('orders')->name('orders.')->group(function(){
        Route::get('ajax', [OrderController::class,'getOrders'])->name('ajax');
        Route::post('{order}/send-to-kitchen', [OrderController::class, 'sendToKitchen'])->name('sendToKitchen');
    });


    Route::patch('kitchen/{order}/complete', [KitchenOrderController::class, 'completeOrder'])->name('kitchen.completeOrder');
    Route::get('kitchen', [KitchenOrderController::class,'index'])->name('kitchen.index');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');
});

require __DIR__.'/auth.php';
