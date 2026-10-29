@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="card">
    <h1>Productos</h1>
    <p>Consulta los productos y controla sus existencias.</p>

    <a class="btn" href="{{ route('productos.create') }}">
        Registrar producto
    </a>

    @if ($productos->count())
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Proveedor</th>
                    <th>Precio</th>
                    <th>Existencias</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->codigo }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>
                            {{ $producto->proveedor
                                ? $producto->proveedor->nombre
                                : 'Sin proveedor' }}
                        </td>
                        <td>${{ number_format($producto->precio, 2) }}</td>
                        <td>{{ $producto->existencias }}</td>
                        <td>
                            @if ($producto->existencias == 0)
                                <strong>Agotado</strong>
                            @elseif ($producto->existencias <= $producto->stock_minimo)
                                <strong>Stock bajo</strong>
                            @else
                                Disponible
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a class="btn"
                                   href="{{ route('productos.show', $producto) }}">
                                    Ver
                                </a>

                                <a class="btn btn-secondary"
                                   href="{{ route('productos.edit', $producto) }}">
                                    Editar
                                </a>

                                <form action="{{ route('productos.destroy', $producto) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger" type="submit">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $productos->links() }}
        </div>
    @else
        <p>Aún no hay productos registrados.</p>
    @endif
</div>
@endsection
