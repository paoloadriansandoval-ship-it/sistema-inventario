
@extends('layouts.app')

@section('title', 'Detalle del producto')

@section('content')
<div class="card">
    <h1>{{ $producto->nombre }}</h1>

    <p><strong>Código:</strong> {{ $producto->codigo }}</p>
    <p><strong>Descripción:</strong> {{ $producto->descripcion ?: 'Sin descripción' }}</p>
    <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
    <p><strong>Existencias:</strong> {{ $producto->existencias }}</p>
    <p><strong>Stock mínimo:</strong> {{ $producto->stock_minimo }}</p>
    <p><strong>Proveedor:</strong>
        {{ $producto->proveedor ? $producto->proveedor->nombre : 'Sin proveedor' }}
    </p>

    @if ($producto->existencias == 0)
        <p><strong>Estado:</strong> Agotado</p>
    @elseif ($producto->existencias <= $producto->stock_minimo)
        <p><strong>Estado:</strong> Stock bajo</p>
    @else
        <p><strong>Estado:</strong> Disponible</p>
    @endif

    <a class="btn"
       href="{{ route('productos.edit', $producto) }}">Editar</a>

    <a class="btn btn-secondary"
       href="{{ route('productos.index') }}">Volver a la lista</a>
</div>
@endsection
