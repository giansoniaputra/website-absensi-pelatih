<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelatihController;
use App\Http\Controllers\RantingController;
use App\Http\Controllers\DashboradController;
use App\Http\Controllers\AbsensiPelatihController;
use App\Models\AbsensiPelatih;

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
Route::resource('/ranting', RantingController::class);
Route::resource('/absensi_pelatih', AbsensiPelatihController::class);


//DATATABLES
Route::get('/datatablesPelatih', [PelatihController::class, 'dataTabless']);
Route::get('/datatablesRanting', [RantingController::class, 'dataTabless']);
Route::get('/datatablesAbsensiPelatih', [AbsensiPelatihController::class, 'dataTabless']);
