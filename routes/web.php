<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WalletController;
use App\Http\Controllers\WebController;


Route::get('', [WebController::class, 'home']);


Route::middleware('auth')->group(function () {

    Route::get('wallet', [WalletController::class, 'wallet_list']);
    Route::post('wallet', [WalletController::class, 'wallet_create']);
    Route::get('wallet/{id}', [WalletController::class, 'wallet_detail']);

    Route::post('chain', [WalletController::class, 'chain_create']);
    
});

require __DIR__.'/auth.php';
