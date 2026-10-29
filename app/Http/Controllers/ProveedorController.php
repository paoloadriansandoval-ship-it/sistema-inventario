<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    
    #Lista los proveedores, de diez en diez.
    public function index()
    {
        $proveedores = Proveedor::orderBy('nombre')->paginate(10);
        return view('proveedores.index', compact('proveedores'));
    }
    #Muestra el formulario para incluir nuevos proveedores
    public function create()
    {
        return view('proveedores.create');
    }

    #Guarda el formulario anterior
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:150',
            'contacto' => 'nullable|string|max:150',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:150',
            'direccion' => 'nullable|string',
        ]);
        Proveedor::create($datos);
        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor registrado correctamente.');
    }

    #Muestra los datos de un proveedor
    public function show(Proveedor $proveedor)
    {
        return view('proveedores.show', compact('proveedor'));
    }

    #Formulario para editar la información de los proveedores
    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    #Guarda los cambios hechos en el formulario anterior
    public function update(Request $request, Proveedor $proveedor)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:150',
            'contacto' => 'nullable|string|max:150',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:150',
            'direccion' => 'nullable|string',
        ]);

        $proveedor->update($datos);

        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }
    #Elimina proveedores, asi sin más
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}

