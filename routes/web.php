<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\FormController;

Route::get('/form', [FormController::class, 'showForm'])->name('show-form');
Route::post('/submit-form', [FormController::class, 'submitForm'])->name('submit-form');
Route::post('/get-historical-data', [FormController::class, 'getHistoricalData'])->name('get-historical-data');


Route::get('/', function () {
    return view('welcome');
});
