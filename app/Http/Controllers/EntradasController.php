<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entradas;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EntradasController extends Controller
{
    public function index()
    {
        $entradas = Entradas::with(['producto', 'proveedor'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('entradas.index', compact('entradas'));
    }

    public function create()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $productos = Producto::orderBy('nombre')->get();

        return view(
            'entradas.create',
            compact('productos', 'proveedores')
        );
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'stock' => 'required|integer|min:1',
            'proveedor_id' => 'nullable|exists:proveedors,id',
            'producto_id' => 'required|exists:productos,id',
        ]);

        DB::transaction(function () use ($datos) {
            // Bloquear el producto mientras se actualiza el inventario.
            $producto = Producto::whereKey($datos['producto_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Registrar la entrada.
            Entradas::create($datos);

            // Sumar las unidades recibidas.
            $producto->increment('existencias', $datos['stock']);
        });

        return redirect()
            ->route('entradas.index')
            ->with(
                'success',
                'Entrada registrada y existencias actualizadas correctamente.'
            );
    }

    public function show(Entradas $entrada)
    {
        $entrada->load(['producto', 'proveedor']);

        return view('entradas.show', compact('entrada'));
    }

    public function edit(Entradas $entrada)
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $productos = Producto::orderBy('nombre')->get();

        return view(
            'entradas.edit',
            compact('entrada', 'productos', 'proveedores')
        );
    }

    public function update(Request $request, Entradas $entrada)
    {
        $datos = $request->validate([
            'stock' => 'required|integer|min:1',
            'proveedor_id' => 'nullable|exists:proveedors,id',
            'producto_id' => 'required|exists:productos,id',
        ]);

        $entradaId = $entrada->getKey();

        DB::transaction(function () use ($datos, $entradaId) {
            // Obtener la versión actual de la entrada y bloquearla.
            $entrada = Entradas::whereKey($entradaId)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$entrada->producto_id) {
                throw ValidationException::withMessages([
                    'producto_id' =>
                        'Esta entrada no tiene un producto asociado. Revisa el registro antes de editarlo.',
                ]);
            }

            $productoAnteriorId = (int) $entrada->producto_id;
            $productoNuevoId = (int) $datos['producto_id'];

            // Bloquear los productos en orden para reducir conflictos.
            $ids = array_unique([
                $productoAnteriorId,
                $productoNuevoId,
            ]);

            sort($ids);

            $productos = Producto::whereIn('id', $ids)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $productoAnterior = $productos->get($productoAnteriorId);
            $productoNuevo = $productos->get($productoNuevoId);

            if (!$productoAnterior || !$productoNuevo) {
                throw ValidationException::withMessages([
                    'producto_id' =>
                        'No se encontró alguno de los productos asociados.',
                ]);
            }

            if ($productoAnteriorId === $productoNuevoId) {
                // Mismo producto:
                // existencias actuales - entrada anterior + entrada nueva.
                $nuevasExistencias =
                    $productoAnterior->existencias
                    - $entrada->stock
                    + $datos['stock'];

                if ($nuevasExistencias < 0) {
                    throw ValidationException::withMessages([
                        'stock' =>
                            'No se puede reducir esta entrada porque dejaría las existencias en negativo.',
                    ]);
                }

                $productoAnterior->existencias = $nuevasExistencias;
                $productoAnterior->save();
            } else {
                // Producto diferente: retirar la contribución anterior.
                $existenciasAnteriores =
                    $productoAnterior->existencias - $entrada->stock;

                if ($existenciasAnteriores < 0) {
                    throw ValidationException::withMessages([
                        'producto_id' =>
                            'No se puede cambiar el producto: sus existencias actuales son insuficientes para revertir esta entrada.',
                    ]);
                }

                $productoAnterior->existencias = $existenciasAnteriores;
                $productoAnterior->save();

                // Incorporar la entrada al nuevo producto.
                $productoNuevo->increment('existencias', $datos['stock']);
            }

            // Guardar los nuevos datos del movimiento.
            $entrada->update($datos);
        });

        return redirect()
            ->route('entradas.index')
            ->with(
                'success',
                'Entrada actualizada y existencias sincronizadas correctamente.'
            );
    }

    public function destroy(Entradas $entrada)
    {
        $entradaId = $entrada->getKey();

        DB::transaction(function () use ($entradaId) {
            $entrada = Entradas::whereKey($entradaId)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$entrada->producto_id) {
                throw ValidationException::withMessages([
                    'entrada' =>
                        'No se puede eliminar esta entrada automáticamente porque no tiene un producto asociado.',
                ]);
            }

            $producto = Producto::whereKey($entrada->producto_id)
                ->lockForUpdate()
                ->first();

            if (!$producto) {
                throw ValidationException::withMessages([
                    'entrada' =>
                        'No se encontró el producto de esta entrada. Revisa el registro antes de eliminarlo.',
                ]);
            }

            // No permitir que eliminar la entrada deje stock negativo.
            if ($producto->existencias < $entrada->stock) {
                throw ValidationException::withMessages([
                    'entrada' =>
                        'No se puede eliminar esta entrada porque las existencias actuales son insuficientes para revertirla.',
                ]);
            }

            // Retirar del inventario las unidades aportadas por la entrada.
            $producto->decrement('existencias', $entrada->stock);

            // Eliminar el movimiento.
            $entrada->delete();
        });

        return redirect()
            ->route('entradas.index')
            ->with(
                'success',
                'Entrada eliminada y existencias actualizadas correctamente.'
            );
    }
}