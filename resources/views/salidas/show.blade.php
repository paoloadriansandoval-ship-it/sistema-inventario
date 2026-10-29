
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle de salida #{{ $salida->id }}</h1>

    <div class="card">
        <div class="card-body">
            <p>
                <strong>Producto:</strong>
                {{ $salida->producto->nombre ?? 'Producto no disponible' }}
            </p>

            <p>
                <strong>Código del producto:</strong>
                {{ $salida->producto->codigo ?? 'No disponible' }}
            </p>

            <p>
                <strong>Cantidad de salida:</strong>
                {{ $salida->stock }}
            </p>

            <p>
                <strong>Fecha de registro:</strong>
                {{ $salida->created_at->format('d/m/Y H:i') }}
            </p>

            <p>
                <strong>Última actualización:</strong>
                {{ $salida->updated_at->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    <a href="{{ route('salidas.edit', $salida) }}"
       class="btn btn-warning mt-3">
        Editar
    </a>

    <a href="{{ route('salidas.index') }}"
       class="btn btn-secondary mt-3">
        Volver al listado
    </a>
</div>
@endsection
