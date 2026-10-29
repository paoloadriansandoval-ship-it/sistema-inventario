
@extends('layouts.app')

@section('title', 'Registrar proveedor')

@section('content')
<div class="card">
    <h1>Registrar proveedor</h1>

    @if ($errors->any())
        <div class="alert error">
            <strong>Revisa los siguientes errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proveedores.store') }}" method="POST">
        @csrf

        <label for="nombre">Nombre *</label>
        <input id="nombre" name="nombre" type="text"
               value="{{ old('nombre') }}" maxlength="150" required>

        <label for="contacto">Persona de contacto</label>
        <input id="contacto" name="contacto" type="text"
               value="{{ old('contacto') }}" maxlength="150">

        <label for="telefono">Teléfono</label>
        <input id="telefono" name="telefono" type="text"
               value="{{ old('telefono') }}" maxlength="30">

        <label for="correo">Correo electrónico</label>
        <input id="correo" name="correo" type="email"
               value="{{ old('correo') }}" maxlength="150">

        <label for="direccion">Dirección</label>
        <textarea id="direccion" name="direccion"
                  rows="3">{{ old('direccion') }}</textarea>

        <p>* Campos obligatorios.</p>

        <button class="btn" type="submit">Guardar proveedor</button>
        <a class="btn btn-secondary"
           href="{{ route('proveedores.index') }}">Cancelar</a>
    </form>
</div>
@endsection
