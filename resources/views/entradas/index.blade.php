@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Entradas de inventario</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('entradas.create') }}"
       class="btn btn-primary mb-3">
        Registrar entrada
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Proveedor</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($entradas as $entrada)
                <tr>
                    <td>{{ $entrada->id }}</td>
                    <td>
                        {{ $entrada->producto->nombre ?? 'Sin producto' }}
                    </td>
                    <td>
                        {{ $entrada->proveedor->nombre ?? 'Sin proveedor' }}
                    </td>
                    <td>{{ $entrada->stock }}</td>
                    <td>{{ $entrada->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('entradas.show', $entrada) }}"
                           class="btn btn-info btn-sm">
                            Ver
                        </a>

                        <a href="{{ route('entradas.edit', $entrada) }}"
                           class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <form action="{{ route('entradas.destroy', $entrada) }}"
                              method="POST"
                              style="display:inline-block">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar esta entrada?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        Todavía no hay entradas registradas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $entradas->links() }}
</div>
@endsection
