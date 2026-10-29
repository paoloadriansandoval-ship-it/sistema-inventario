<?php

namespace App\Http\Controllers;

use App\Models\Producto;
#Se importa proveedor también porque esta tabla depende de la otra
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    #Mostrar todo
    public function index()
    {
        $productos = Producto::with('proveedor')
            ->orderBy('nombre')
            ->paginate(10);

        return view('productos.index', compact('productos'));
    }
    #Formulario para agregar productos
    public function create()
    {
        #con conexión directa a la tabla proveedores para poder incluirlos
        $proveedores = Proveedor::orderBy('nombre')->get();
        return view('productos.create', compact('proveedores'));
    }

    #Guardar
    public function store(Request $request)
    {
        $datos = $request->validate([
            'codigo' => 'required|string|max:50|unique:productos,codigo',
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'existencias' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'proveedor_id' => 'nullable|exists:proveedors,id',
        ]);

        Producto::create($datos);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    #Mostrar uno
    public function show(Producto $producto)
    {
        $producto->load('proveedor');

        return view('productos.show', compact('producto'));
    }

    #Formulario editar
    public function edit(Producto $producto)
    {
        $proveedores = Proveedor::orderBy('nombre')->get();

        return view('productos.edit', compact('producto', 'proveedores'));
    }

    #Editar
    public function update(Request $request, Producto $producto)
    {
        $datos = $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('productos', 'codigo')->ignore($producto->id),
            ],
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'existencias' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'proveedor_id' => 'nullable|exists:proveedors,id',
        ]);

        $producto->update($datos);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    #Eliminar
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
