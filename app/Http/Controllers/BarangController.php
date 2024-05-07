<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\RegistroAlumno;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listaAlumnos = RegistroAlumno::orderBy('codigo', 'asc')->get();

        return view('barang.barang', [
            'barang' => $listaAlumnos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.barang-add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:barangs',
            'category' => 'required',
            'supplier' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'note' => 'max:1000',
        ]);

        $barang = Barang::create($request->all());

        Alert::success('Success', 'Barang has been saved !');
        return redirect('/barang');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($codigo)
    {
        $barang = RegistroAlumno::findOrFail($codigo);

        return view('barang.barang-edit', [
            'barang' => $barang,
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $codigo)
    {
        $validated = $request->validate([
            'codigo' => 'required|max:100|unique:barangs,name,' . $codigo . ',id_barang',
            'apellido' => 'required',
            'supplier' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'note' => 'max:1000',
        ]);

        $barang = RegistroAlumno::findOrFail($codigo);
        $barang->update($validated);

        Alert::info('Success', 'Barang has been updated !');
        return redirect('/barang');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_barang)
    {
        try {
            $deletedbarang = Barang::findOrFail($id_barang);

            $deletedbarang->delete();

            Alert::error('Success', 'Barang has been deleted !');
            return redirect('/barang');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Barang already used !');
            return redirect('/barang');
        }
    }
}
