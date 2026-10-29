
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Salidas de inventario</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('salidas.create') }}"
       class="btn btn-primary mb-3">
        Registrar salida
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($salidas as $salida)
                <tr>
                    <td>{{ $salida->id }}</td>

                    <td>
                        {{ $salida->producto->nombre ?? 'Producto no disponible' }}
                    </td>

                    <td>{{ $salida->stock }}</td>

                    <td>
                        {{ $salida->created_at->format('d/m/Y H:i') }}
                    </td>

                    <td>
                        <a href="{{ route('salidas.show', $salida) }}"
                           class="btn btn-info btn-sm">
                            Ver
                        </a>

                        <a href="{{ route('salidas.edit', $salida) }}"
                           class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <form action="{{ route('salidas.destroy', $salida) }}"
                              method="POST"
                              style="display:inline-block">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar esta salida y restaurar las existencias?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        Todavía no hay salidas registradas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $salidas->links() }}
</div>
@endsection
