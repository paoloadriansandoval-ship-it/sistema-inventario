
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle de entrada #{{ $entrada->id }}</h1>

    <div class="card">
        <div class="card-body">
            <p>
                <strong>Producto:</strong>
                {{ $entrada->producto->nombre ?? 'Sin producto' }}
            </p>

            <p>
                <strong>Código del producto:</strong>
                {{ $entrada->producto->codigo ?? 'No disponible' }}
            </p>

            <p>
                <strong>Proveedor:</strong>
                {{ $entrada->proveedor->nombre ?? 'Sin proveedor' }}
            </p>

            <p>
                <strong>Cantidad recibida:</strong>
                {{ $entrada->stock }}
            </p>

            <p>
                <strong>Fecha de registro:</strong>
                {{ $entrada->created_at->format('d/m/Y H:i') }}
            </p>

            <p>
                <strong>Última actualización:</strong>
                {{ $entrada->updated_at->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    <a href="{{ route('entradas.edit', $entrada) }}"
       class="btn btn-warning mt-3">
        Editar
    </a>

    <a href="{{ route('entradas.index') }}"
       class="btn btn-secondary mt-3">
        Volver al listado
    </a>
</div>
@endsection
