<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    public function index(){
        $listaAlumnos = User::where('TipoUsuario', 'profesor')->orderBy('id_user')->get();

        return view('horario.horasGeneral', [
            'barang' => $listaAlumnos
        ]);
    }

    public function edit($id_user, Request $request)
    {
        $barang = User::findOrFail($id_user);
        
        return view('horario.registrarHorario', [
            'barang' => $barang
        ]);
        
    }

    public function update(Request $request, $id_user)
    {
        $fecha_actual = Carbon::now();
        
        $hora = $request->input('horario');
        $carril = $request->input('carril');
        $nalumnos = $request->input('nalumnos');
        $observaciones = $request->input('observaciones');
        $fecha_formateada = $fecha_actual->format('d-m-Y');


        $verificar= DB::table('horarios')
                    ->select(DB::raw('COUNT(horarios.carril) as carril'))
                    ->where('carril', '=', $carril)
                    ->where('fecha', '=', $fecha_formateada)
                    ->where('hora', '=', $hora)
                    ->first();
        if($verificar->carril == 1){

            Alert::warning('Error', 'Carril Ocupado!');
            return redirect('/horarios');

        }else{

            $horario = new Horario();
            $horario->hora = $hora;
            $horario->id_user = $id_user;
            $horario->carril = $carril;
            $horario->nalumnos = $nalumnos;
            $horario->observaciones = $observaciones;
            $horario->fecha = $fecha_formateada; 
            $horario->save();


            Alert::success('Success', 'Turno Registrado !');
            return redirect('/horarios');


        }
        
    }

}
