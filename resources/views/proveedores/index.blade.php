
@extends('layouts.app')

@section('title', 'Proveedores')

@section('content')
<div class="card">
    <h1>Proveedores</h1>
    <p>Administra los proveedores de tu inventario.</p>

    <a class="btn" href="{{ route('proveedores.create') }}">
        Registrar proveedor
    </a>

    @if ($proveedores->count())
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->contacto ?: '—' }}</td>
                        <td>{{ $proveedor->telefono ?: '—' }}</td>
                        <td>{{ $proveedor->correo ?: '—' }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn"
                                   href="{{ route('proveedores.show', $proveedor) }}">
                                    Ver
                                </a>

                                <a class="btn btn-secondary"
                                   href="{{ route('proveedores.edit', $proveedor) }}">
                                    Editar
                                </a>

                                <form
                                    action="{{ route('proveedores.destroy', $proveedor) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Eliminar este proveedor?')">
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
            {{ $proveedores->links() }}
        </div>
    @else
        <p>Aún no hay proveedores registrados.</p>
    @endif
</div>
@endsection
