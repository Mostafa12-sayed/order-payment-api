<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;


Route::post('/orders/pay', [OrderController::class, 'pay']);
