<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\producto;
use App\Models\venta;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
class ProductoController extends Controller
{
    public function indexProductos()
    {
        return view('productos.producto-add');
    }

    public function store(Request $request)
     {
        $nombre = $request->input('nombre');
        $id_producto = $request->input('id_producto');
        $categoria = $request->input('categoria');
        $precio = $request->input('precio');
        $stock = $request->input('stock');

        $producto = new Producto();
        $producto->nombre = $nombre;
        $producto->id_producto = $id_producto;
        $producto->categoria = $categoria;
        $producto->precio = $precio;
        $producto->stock = $stock;
        $producto->save();

        return redirect()->back()->with('success', 'Producto registrado correctamente');
            
    }
    public function indexlistProd()
    {
        $productos = producto::all();
        return view('productos.listaProductos', ['productos' => $productos]);
    }
    public function editar($id_producto)
    {
    $producto = producto::where('id_producto', $id_producto)->firstOrFail();

    return view('productos.producto-edit', [
        'producto' => $producto,
    ]);
    }
    public function update(Request $request, $id_producto)
    {
    $validated = $request->validate([
        'nombre' => 'required',
        'categoria' => 'required',
        'precio' => 'required|numeric',
        'stock' => 'required|numeric',
    ]);
    
    $producto = producto::where('id_producto', $id_producto)->firstOrFail();
    $producto->update($validated);
    
    Alert::info('Exitoso', 'Producto actualizado correctamente');
    return redirect('/dashboard/listaproductos');
    }
    public function indexVentas()
    {
        
        return view('productos.ventaProductos');
    }
    public function fetchProductById(Request $request)
    {
    $id_producto = $request->input('id_producto');
    $producto = Producto::where('id_producto', $id_producto)->first();

    if ($producto) {
        return response()->json([
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
            'id_producto' => $producto->id_producto
        ]);
    } else {
        return response()->json(['error' => 'Producto no encontrado'], 404);
    }
    }
    public function storeVenta(Request $request)
{
    $productos = $request->input('productos'); // Array de productos
    $total = $request->input('total');
    $vendedor = Auth::user()->name; // Sistema de autenticación

    // Verificar si el array de productos no está vacío
    if (!is_array($productos) || empty($productos)) {
        return redirect()->back()->with('error', 'No se han agregado productos a la venta.');
    }

    // Recorrer los productos y guardarlos en la tabla de ventas
    foreach ($productos as $producto) {
        // Buscar el producto en la base de datos
        $productoDB = Producto::where('id_producto', $producto['id_producto'])->first();

        if ($productoDB) {
            // Reducir el stock del producto
            $productoDB->stock -= $producto['cantidad'];

            // Verificar si hay suficiente stock
            if ($productoDB->stock < 0) {
                return redirect()->back()->with('error', 'No hay suficiente stock para el producto: ' . $producto['nombre']);
            }

            // Guardar los cambios del stock en la base de datos
            $productoDB->save();

            // Crear la venta
            Venta::create([
                'nombre' => $producto['nombre'], // Datos del array de productos
                'cantidad' => $producto['cantidad'],
                'vendedor' => $vendedor,
                'total' => $producto['precio'] * $producto['cantidad'] // Total por producto
            ]);
        }
    }

    return redirect()->back()->with('success', 'Venta realizada exitosamente');
}


    

}