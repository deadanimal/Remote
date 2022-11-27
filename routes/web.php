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
    Route::put('wallet/{id}', [WalletController::class, 'wallet_update']);
    Route::delete('wallet/{id}', [WalletController::class, 'wallet_delete']);

    Route::get('chain', [WalletController::class, 'chain_list']);
    Route::post('chain', [WalletController::class, 'chain_create']);
    Route::get('chain/{id}', [WalletController::class, 'chain_detail']);
    Route::put('chain/{id}', [WalletController::class, 'chain_update']);
    Route::delete('chain/{id}', [WalletController::class, 'chain_delete']);

    Route::get('transaction', [WalletController::class, 'transaction_list']);
    Route::post('transaction', [WalletController::class, 'transaction_create']);  
    
    Route::get('transfer', [WalletController::class, 'transfer_list']);
    Route::post('transfer', [WalletController::class, 'transfer_create']);      
    
});

require __DIR__.'/auth.php';
