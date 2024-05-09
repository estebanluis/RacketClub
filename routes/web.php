<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\RegistroAlumnosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControlAlumnController;
use App\Http\Controllers\HorasTProfController;
use App\Http\Controllers\verTurnosController;

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
//route login
//Route::get('/barang/{codigo}/edit', [BarangController::class, 'edit']);
Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'process']);
Route::get('/registrarAlumno', [RegistroAlumnosController::class, 'index']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::post('/registrar', [RegistroAlumnosController::class, 'store'])->name('registrarAlumn.store');
Route::get('/registerUser', [AuthController::class, 'registerUser']);
Route::post('/registerUser', [AuthController::class, 'processUser']);
Route::get('/dashboard/tomarAsistencia', [ControlAlumnController::class, 'indexAsistencia']);
Route::post('/dashboard/tomarAsistencia', [ControlAlumnController::class, 'update'])->name('registrarAlumn.update');

// route dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

//route barang
Route::resource('/barang', BarangController::class)->middleware('auth');

//route registrar horario
Route::resource('/horarios', HorarioController::class);

//route ver Turnos
Route::resource('/turnos', verTurnosController::class);
Route::get('/turnos/{id_user}/{fecha}', [verTurnosController::class, 'showWithDate'])->name('turnos.showWithDate');

//route ver pago 
Route::resource('/hprof', HorasTProfController::class);
