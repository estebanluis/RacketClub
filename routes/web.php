<?php

use App\Http\Controllers\AtencionRacketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\RegistroAlumnosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControlAlumnController;
use App\Http\Controllers\HorasTProfController;
use App\Http\Controllers\PiscinaFindeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\ReservaCanchaController;
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
Route::get('/generar-pdf/{codigo}', [RegistroAlumnosController::class, 'generarPdf'])->name('generarPdf');
// route dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::post('/reinscribir/{id}', [BarangController::class, 'reinscribirAlumn'])->name('reinscribir.alumn');
Route::get('/ruta/para/reinscribir/{id}', [BarangController::class, 'showReinscribirForm'])->name('reinscribir.form');
//route barang
Route::resource('/barang', BarangController::class)->middleware('auth');
Route::post('/generate-pdf/{id}', [BarangController::class, 'generatePDF'])->name('generate.pdf');
//route registrar horario
//route barang
Route::resource('/barang', BarangController::class)->middleware('auth');
//route registrar horario
Route::resource('/horarios', HorarioController::class);
// Ruta para mostrar la tabla de "Turnos Trabajados"
Route::get('/turnos', [verTurnosController::class, 'index'])->name('turnos.index');
// Ruta para ver los detalles de un turno específico
Route::get('/turnos/detalles/{id_user}/{fecha}', [verTurnosController::class, 'showWithDate'])->name('turnos.showWithDate');
// Ruta para mostrar el formulario de agregar/editar salario
Route::get('/turnos/salario/{idHorario}', [verTurnosController::class, 'showSalarioForm'])->name('turnos.salario.formulario');

// Ruta para actualizar el salario
Route::put('/turnos/salario/{idHorario}', [verTurnosController::class, 'updateSalario'])->name('turnos.salario.actualizar');

//route ver pago 
Route::resource('/hprof', HorasTProfController::class);
//reservar Cancha
Route::resource('/rcancha', ReservaCanchaController::class);
//atencion racket
Route::resource('/atenracket', AtencionRacketController::class);
// Pasar a atención
Route::post('/rcancha/{id}/atencion', [ReservaCanchaController::class, 'transferToAtencion'])->name('rcancha.transferToAtencion');


//route ver productos
Route::get('/dashboard/agreagar-productos', [ProductoController::class, 'indexProductos']);
Route::post('/dashboard/agreagar-productos', [ProductoController::class, 'store'])->name('productos.store');
Route::get('/dashboard/listaproductos', [ProductoController::class, 'indexlistProd']);
Route::get('/productos/{id}/edit', [ProductoController::class, 'editar'])->name('productos.edit');
route::get('/productos/{id_producto}/edit', [ProductoController::class, 'editar'])->name('productos.edit');
Route::put('/productos/{id_producto}', [ProductoController::class, 'update'])->name('productos.update');
Route::post('/aniadirStock', [ProductoController::class, 'aniadirStock'])->name('aniadirStock');
//rutas de ventas
Route::get('/ventas', [ProductoController::class, 'indexVentas']);
Route::post('/productos/fetch-product', [ProductoController::class, 'fetchProductById'])->name('productos.fetch');
Route::post('/ventas/store', [ProductoController::class, 'storeVenta'])->name('storeVenta');
//rutas reportes
Route::get('/reporte', [ReportesController::class, 'indexReporte']);
Route::get('/reporte-estudiantes', [ReportesController::class, 'obtenerEstudiantesPorDia']);
Route::get('/reporte-estudiantes', [ReportesController::class, 'obtenerEstudiantesPorDia']);
Route::get('/generar-informe/{dia}/{mes}/{anio}', [ReportesController::class, 'generarInforme']);

// Ruta para mostrar la lista de atenciones
Route::get('/piscinaFinde', [PiscinaFindeController::class, 'index'])->name('piscina.index');
// Ruta para registrar una nueva atención (desde el formulario en el modal)
Route::post('/piscinaFinde/store', [PiscinaFindeController::class, 'store'])->name('piscina.register');
// Ruta para finalizar la atención
Route::put('/piscinaFinde/finalizar/{id}', [PiscinaFindeController::class, 'finalizar'])->name('piscina.finalizar');
