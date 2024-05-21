<?php

use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('welcome');
});
Route::post('/customer-loans',   [LoanController::class, 'customerLoans']);
