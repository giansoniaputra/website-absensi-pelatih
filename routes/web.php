<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelatihController;
use App\Http\Controllers\DashboradController;

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

Route::get('/', [DashboradController::class, 'index']);

//Data Pelatih
Route::resource('/pelatih', PelatihController::class);


//DATATABLES
Route::get('/datatablesPelatih', [PelatihController::class, 'dataTabless']);
