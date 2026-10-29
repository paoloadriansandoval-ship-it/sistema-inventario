
@extends('layouts.app')

@section('title', 'Editar proveedor')

@section('content')
<div class="card">
    <h1>Editar proveedor</h1>

    @if ($errors->any())
        <div class="alert error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proveedores.update', $proveedor) }}"
          method="POST">
        @csrf
        @method('PUT')

        <label for="nombre">Nombre *</label>
        <input id="nombre" name="nombre" type="text"
               value="{{ old('nombre', $proveedor->nombre) }}"
               maxlength="150" required>

        <label for="contacto">Persona de contacto</label>
        <input id="contacto" name="contacto" type="text"
               value="{{ old('contacto', $proveedor->contacto) }}"
               maxlength="150">

        <label for="telefono">Teléfono</label>
        <input id="telefono" name="telefono" type="text"
               value="{{ old('telefono', $proveedor->telefono) }}"
               maxlength="30">

        <label for="correo">Correo electrónico</label>
        <input id="correo" name="correo" type="email"
               value="{{ old('correo', $proveedor->correo) }}"
               maxlength="150">

        <label for="direccion">Dirección</label>
        <textarea id="direccion" name="direccion"
                  rows="3">{{ old('direccion', $proveedor->direccion) }}</textarea>

        <button class="btn" type="submit">Guardar cambios</button>
        <a class="btn btn-secondary"
           href="{{ route('proveedores.index') }}">Cancelar</a>
    </form>
</div>
@endsection
