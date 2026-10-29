
@extends('layouts.app')

@section('title', 'Detalle del proveedor')

@section('content')
<div class="card">
    <h1>Detalle del proveedor</h1>

    <p><strong>Nombre:</strong> {{ $proveedor->nombre }}</p>
    <p><strong>Contacto:</strong> {{ $proveedor->contacto ?: 'No registrado' }}</p>
    <p><strong>Teléfono:</strong> {{ $proveedor->telefono ?: 'No registrado' }}</p>
    <p><strong>Correo:</strong> {{ $proveedor->correo ?: 'No registrado' }}</p>
    <p><strong>Dirección:</strong> {{ $proveedor->direccion ?: 'No registrada' }}</p>

    <a class="btn"
       href="{{ route('proveedores.edit', $proveedor) }}">Editar</a>

    <a class="btn btn-secondary"
       href="{{ route('proveedores.index') }}">Volver a la lista</a>
</div>
@endsection
