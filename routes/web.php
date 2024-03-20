<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimeLogController;
use App\Http\Controllers\Admin\TimeLogController as LogController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\ProjectController;
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
/*This is for admin access,*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [MainController::class, 'index'])->name('admin/dashboard');
    Route::resource('admin/projects', ProjectController::class);
    Route::get('/assign/{id}', [ProjectController::class, 'assign'])->name('assign');
    Route::get('view-log/{uId}/{pId}', [LogController::class, 'logs'])->name('view-log');
    Route::resource('logs', LogController::class);
});

/*this is for simple user*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::resource('time-logs', TimeLogController::class);
    Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user/dashboard');
    Route::get('tracking/{id}', [TimeLogController::class, 'tracking'])->name('tracking');
    Route::get('/statistics/{id}', [TimeLogController::class, 'statistics'])->name('statistics');
    Route::get('/tracking/{id}', [TimeLogController::class, 'tracking'])->name('tracking');
});


Route::post('signIn', [AuthenticationController::class, 'login'])->name('signIn');
Route::get('/', [MainController::class, 'auth'])->name('index');

//Route::get('/', function () {
//    return view('welcome');
//})->middleware('auth');
//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__ . '/auth.php';
