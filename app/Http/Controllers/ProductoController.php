<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\producto;
use App\Models\productoRack;
use App\Models\venta;
use App\Models\ventasR;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\AniadirStock;
use App\Models\AniadirStockR;
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
    public function storeR(Request $request)
     {
        $nombreR = $request->input('nombreR');
        $id_productoR = $request->input('id_productoR');
        $categoriaR = $request->input('categoriaR');
        $precioR = $request->input('precioR');
        $stockR = $request->input('stockR');

        $producto = new productoRack();
        $producto->nombreR = $nombreR;
        $producto->id_productoR = $id_productoR;
        $producto->categoriaR = $categoriaR;
        $producto->precioR = $precioR;
        $producto->stockR = $stockR;
        $producto->save();

        return redirect()->back()->with('success', 'Producto registrado correctamente');
            
    }
    public function indexlistProd()
    {
        $productos = producto::all();
        return view('productos.listaProductos', ['productos' => $productos]);
    }
    public function indexlistProdR()
    {
        $productosR = productoRack::all();
        return view('productos.listaProductosR', ['productosR' => $productosR]);
    }
    public function editar($id_producto)
    {
    $producto = producto::where('id_producto', $id_producto)->firstOrFail();

    return view('productos.producto-edit', [
        'producto' => $producto,
    ]);
    }
    public function update(Request $request, $id_producto)
    
    {// Validación de los datos recibidos
    $request->validate([
        'nombre' => 'required|string|max:100',
        'categoria' => 'required|string|max:50',
        'stock' => 'required|integer|min:0',
        'precio' => 'required|integer|min:0',
    ]);

    // Buscar el producto por su ID
    $producto = Producto::findOrFail($id_producto);

    // Actualizar los campos
    $producto->nombre = $request->nombre;
    $producto->categoria = $request->categoria;
    $producto->stock = $request->stock;
    $producto->precio = $request->precio;
    
    // Guardar los cambios en la base de datos
    $producto->save();

    // Redireccionar de nuevo a la lista de productos con un mensaje de éxito
    return redirect()->back()->with('success', 'Producto actualizado con éxito');

    }
    public function updateR(Request $request, $id_productoR)
    
    {// Validación de los datos recibidos
    $request->validate([
        'nombreR' => 'required|string|max:100',
        'categoriaR' => 'required|string|max:50',
        'stockR' => 'required|integer|min:0',
        'precioR' => 'required|integer|min:0',
    ]);

    // Buscar el producto por su ID
    $producto = productoRack::findOrFail($id_productoR);

    // Actualizar los campos
    $producto->nombreR = $request->nombreR;
    $producto->categoriaR = $request->categoriaR;
    $producto->stockR = $request->stockR;
    $producto->precioR = $request->precioR;
    
    // Guardar los cambios en la base de datos
    $producto->save();

    // Redireccionar de nuevo a la lista de productos con un mensaje de éxito
    return redirect()->back()->with('success3', 'Producto actualizado con éxito');

    }
    public function indexVentas()
    {
        return view('productos.ventaProductos');
    }
    public function indexVentasR()
    {
        
        return view('productos.ventaProductosR');
    }
    public function fetchProductById(Request $request)
    {
    $id_producto = $request->input('id_producto');
    $producto = producto::where('id_producto', $id_producto)->first();

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
    public function fetchProductByIdR(Request $request)
    {
    $id_productoR = $request->input('id_productoR');
    $producto = productoRack::where('id_productoR', $id_productoR)->first();

    if ($producto) {
        return response()->json([
            'nombre' => $producto->nombreR,
            'precio' => $producto->precioR,
            'id_producto' => $producto->id_productoR
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
                Alert::info('Advertencia', 'No hay suficiente stock para el producto: ' . $producto['nombre']);
                return redirect()->back();
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
public function storeVentaR(Request $request)
{
    
    $productos = $request->input('productosR'); // Array de productos
    $total = $request->input('total');
    $vendedor = Auth::user()->name; // Sistema de autenticación

    // Verificar si el array de productos no está vacío
    if (!is_array($productos) || empty($productos)) {
        return redirect()->back()->with('error', 'No se han agregado productos a la venta.');
    }

    // Recorrer los productos y guardarlos en la tabla de ventas
    foreach ($productos as $producto) {
        // Buscar el producto en la base de datos
        $productoDB = productoRack::where('id_productoR', $producto['id_productoR'])->first();

        if ($productoDB) {
            // Reducir el stock del producto
            $productoDB->stockR -= $producto['cantidadR'];

            // Verificar si hay suficiente stock
            if ($productoDB->stockR < 0) {
                Alert::info('Advertencia', 'No hay suficiente stock para el producto: ' . $producto['nombreR']);
                return redirect()->back();
            }

            // Guardar los cambios del stock en la base de datos
            $productoDB->save();

            // Crear la venta
            VentasR::create([
                'nombreR' => $producto['nombreR'], // Datos del array de productos
                'cantidadR' => $producto['cantidadR'],
                'vendedorR' => $vendedor,
                'totalR' => $producto['precioR'] * $producto['cantidadR'] // Total por producto
            ]);
        }
    }

    return redirect()->back()->with('success', 'Venta realizada exitosamente');
}

public function aniadirStock(Request $request)
{
    $request->validate([
        'cantidad' => 'required|numeric',
        'pagoDistribuidor' => 'required|numeric',
        'precioProducto' => 'required|numeric',
    ]);

    // Actualizar la tabla productos
    $producto = Producto::findOrFail($request->id_producto);
    $producto->stock += $request->cantidad;
    $producto->precio = $request->precioProducto;
    $producto->save();

    // Insertar en la tabla aniadirStock
    $stockEntry = new AniadirStock();
    $stockEntry->nombreProducto = $producto->nombre;
    $stockEntry->id_producto_aniadido = $producto->id_producto;
    $stockEntry->catidad_aniadida = $request->cantidad;
    $stockEntry->responsable = Auth::user()->name;
    $stockEntry->pago_distribuidor = $request->pagoDistribuidor;
    $stockEntry->save();

    return redirect()->back()->with('success', 'Stock añadido correctamente');
}
public function aniadirStockR(Request $request)
{
    $request->validate([
        'cantidadR' => 'required|numeric',
        'pagoDistribuidorR' => 'required|numeric',
        'precioProductoR' => 'required|numeric',
    ]);

    // Actualizar la tabla productos
    $producto = productoRack::findOrFail($request->id_productoR);
    $producto->stockR += $request->cantidadR;
    $producto->precioR = $request->precioProductoR;
    $producto->save();

    // Insertar en la tabla aniadirStock
    $stockEntry = new aniadirStockR();
    $stockEntry->nombreProductoR = $producto->nombreR;
    $stockEntry->id_producto_aniadidoR = $producto->id_productoR;
    $stockEntry->catidad_aniadidaR = $request->cantidadR;
    $stockEntry->responsableR = Auth::user()->name;
    $stockEntry->pago_distribuidorR = $request->pagoDistribuidorR;
    $stockEntry->save();

    return redirect()->back()->with('success3', 'Stock añadido correctamente');
}
public function destroy($id_producto)
{
    // Buscar el producto por su id
    $producto = Producto::findOrFail($id_producto);

    // Eliminar el producto
    $producto->delete();

    // Redirigir con un mensaje de éxito
    return redirect()->back()->with('success', 'Producto eliminado correctamente.');
}
public function destroyR($id_productoR)
{
    // Buscar el producto por su id
    $producto = productoRack::findOrFail($id_productoR);

    // Eliminar el producto
    $producto->delete();

    // Redirigir con un mensaje de éxito
    return redirect()->back()->with('success1', 'Producto eliminado correctamente.');
}
    

}