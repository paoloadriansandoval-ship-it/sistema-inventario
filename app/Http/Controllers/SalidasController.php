<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salidas;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SalidasController extends Controller
{
    public function index()
    {
        $salidas = Salidas::with('producto')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('salidas.index', compact('salidas'));
    }

    public function create()
    {
        $productos = Producto::orderBy('nombre')->get();

        return view('salidas.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'stock' => 'required|integer|min:1',
            'producto_id' => 'required|exists:productos,id',
        ]);

        DB::transaction(function () use ($datos) {
            // Bloquear el producto durante la operación
            $producto = Producto::whereKey($datos['producto_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Verificar que haya suficientes unidades
            if ($producto->existencias < $datos['stock']) {
                throw ValidationException::withMessages([
                    'stock' => 'No hay existencias suficientes para esta salida.',
                ]);
            }

            // Registrar la salida
            Salidas::create($datos);

            // Descontar las unidades del inventario
            $producto->decrement('existencias', $datos['stock']);
        });

        return redirect()
            ->route('salidas.index')
            ->with('success', 'Salida registrada y existencias actualizadas correctamente.');
    }

    public function show(Salidas $salida)
    {
        $salida->load('producto');

        return view('salidas.show', compact('salida'));
    }

    public function edit(Salidas $salida)
    {
        $productos = Producto::orderBy('nombre')->get();

        return view('salidas.edit', compact('salida', 'productos'));
    }

    public function update(Request $request, Salidas $salida)
    {
        $datos = $request->validate([
            'stock' => 'required|integer|min:1',
            'producto_id' => 'required|exists:productos,id',
        ]);

        DB::transaction(function () use ($datos, $salida) {
            // Bloquear los productos implicados para evitar
            // inconsistencias si dos operaciones ocurren a la vez.
            $ids = array_unique([
                $salida->producto_id,
                $datos['producto_id'],
            ]);

            sort($ids);

            $productos = Producto::whereIn('id', $ids)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $productoAnterior = $productos->get($salida->producto_id);
            $productoNuevo = $productos->get($datos['producto_id']);

            if (!$productoAnterior || !$productoNuevo) {
                throw ValidationException::withMessages([
                    'producto_id' => 'No se encontró el producto seleccionado.',
                ]);
            }

            // Devolver al inventario la salida original
            $productoAnterior->increment('existencias', $salida->stock);

            // Comprobar stock para la salida modificada
            if ($productoNuevo->existencias < $datos['stock']) {
                throw ValidationException::withMessages([
                    'stock' => 'No hay existencias suficientes para esta salida.',
                ]);
            }

            // Descontar la nueva cantidad
            $productoNuevo->decrement('existencias', $datos['stock']);

            // Actualizar el registro de salida
            $salida->update($datos);
        });

        return redirect()
            ->route('salidas.index')
            ->with('success', 'Salida actualizada y existencias sincronizadas correctamente.');
    }

    public function destroy(Salidas $salida)
    {
        DB::transaction(function () use ($salida) {
            // Bloquear el producto antes de devolver las unidades
            $producto = Producto::whereKey($salida->producto_id)
                ->lockForUpdate()
                ->first();

            // Si el producto todavía existe, devolver las unidades
            if ($producto) {
                $producto->increment('existencias', $salida->stock);
            }

            $salida->delete();
        });

        return redirect()
            ->route('salidas.index')
            ->with('success', 'Salida eliminada y existencias restauradas correctamente.');
    }
}
