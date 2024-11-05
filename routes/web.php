<?php
use App\Models\fechasAsistencia;
use App\Http\Controllers\AtencionRacketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\RegistroAlumnosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControlAlumnController;
use App\Http\Controllers\HorasProfesorController;
use App\Http\Controllers\HorasTProfController;
use App\Http\Controllers\ListUserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PiscinaFindeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\ReservaCanchaController;
use App\Http\Controllers\SesionesContrller;
use App\Http\Controllers\UserController;
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
Route::get('/listaSeciones', [SesionesContrller::class, 'index']);
Route::get('/registrarAlumno', [RegistroAlumnosController::class, 'index']);
Route::post('/listaSeciones', [SesionesContrller::class, 'storeSesion'])->name('registrarAlumn.storeSesion');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::post('/registrar', [RegistroAlumnosController::class, 'store'])->name('registrarAlumn.store');
Route::get('/registerUser', [AuthController::class, 'registerUser']);
Route::post('/registerUser', [AuthController::class, 'processUser']);
Route::get('/dashboard/tomarAsistencia', [ControlAlumnController::class, 'indexAsistencia']);
Route::post('/dashboard/tomarAsistencia', [ControlAlumnController::class, 'update'])->name('registrarAlumn.update');
Route::post('/controlAlumn/obtenerAlumno', [ControlAlumnController::class, 'obtenerAlumno'])->name('controlAlumn.obtenerAlumno');
Route::delete('/listaClientes/{id}', [RegistroAlumnosController::class, 'destroy'])->name('barang.destroy');
Route::get('/generar-pdf/{codigo}', [RegistroAlumnosController::class, 'generarPdf'])->name('generarPdf');
Route::get('/stream-sse', [ControlAlumnController::class, 'streamSSE']);
// route dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::post('/reinscribir/{id}', [BarangController::class, 'reinscribirAlumn'])->name('reinscribir.alumn');
Route::get('/ruta/para/reinscribir/{id}', [BarangController::class, 'showReinscribirForm'])->name('reinscribir.form');
Route::get('/obtener-asistencias', [DashboardController::class, 'obtenerFechas']);
Route::post('/subir-anuncio', [DashboardController::class, 'subir'])->name('anuncios.subir');
Route::get('/obtener-fechas', [DashboardController::class, 'obtenerFechas']);
Route::post('/subir-anuncio', [DashboardController::class, 'subirAnuncio']);

//route barang
Route::resource('/barang', BarangController::class)->middleware('auth');
Route::post('/generate-pdf/{id}', [BarangController::class, 'generatePDF'])->name('generate.pdf');
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
// Rutas de reservas
Route::post('/reservas/transferir-atencion/{id}', [AtencionRacketController::class, 'transferToAtencion'])->name('reservas.transferirAtencion');

//atencion racket
Route::resource('/atenracket', AtencionRacketController::class);
// Pasar a atención
Route::post('/rcancha/{id}/atencion', [ReservaCanchaController::class, 'transferToAtencion'])->name('rcancha.transferToAtencion');


//route ver productos
Route::get('/dashboard/agreagar-productos', [ProductoController::class, 'indexProductos']);
Route::post('/dashboard/agreagar-productos', [ProductoController::class, 'store'])->name('productos.store');
Route::get('/dashboard/listaproductos', [ProductoController::class, 'indexlistProd']);
Route::get('/dashboard/listaproductos', [ProductoController::class, 'indexlistProd'])->name('productos.list');
Route::put('/dashboard/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
Route::post('/aniadirStock', [ProductoController::class, 'aniadirStock'])->name('aniadirStock');
Route::resource('productos', ProductoController::class);
Route::put('/productos/{id_producto}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/productos/{id_producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

// Ruta específica para la actualización de productos
Route::put('/productos/{id_producto}', [ProductoController::class, 'update'])->name('productos.update');
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
//ruta lista usuarios 
Route::resource('/luser', ListUserController::class);
//ruta para verificar la sesion 
Route::resource('/tula', HorasProfesorController::class);

Route::get('/check-session', function () {
    return response()->json(['expired' => !auth()->check()]);

});


Route::post('/notify', [NotificationController::class, 'notify'])->name('notify');
Route::put('/user/update', [UserController::class, 'update'])->name('user.update');
