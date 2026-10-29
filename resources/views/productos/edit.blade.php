
@extends('layouts.app')

@section('title', 'Editar producto')

@section('content')
<div class="card">
    <h1>Editar producto</h1>

    @if ($errors->any())
        <div class="alert error">
            <strong>Revisa los errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.update', $producto) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="codigo">Código *</label>
        <input id="codigo" name="codigo" type="text"
               value="{{ old('codigo', $producto->codigo) }}"
               maxlength="50" required>

        <label for="nombre">Nombre *</label>
        <input id="nombre" name="nombre" type="text"
               value="{{ old('nombre', $producto->nombre) }}"
               maxlength="150" required>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion"
                  rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>

        <label for="precio">Precio unitario *</label>
        <input id="precio" name="precio" type="number"
               min="0" step="0.01"
               value="{{ old('precio', $producto->precio) }}" required>

        <label for="existencias">Existencias *</label>
        <input id="existencias" name="existencias" type="number"
               min="0" step="1"
               value="{{ old('existencias', $producto->existencias) }}" required>

        <label for="stock_minimo">Stock mínimo *</label>
        <input id="stock_minimo" name="stock_minimo" type="number"
               min="0" step="1"
               value="{{ old('stock_minimo', $producto->stock_minimo) }}" required>

        <label for="proveedor_id">Proveedor</label>
        <select id="proveedor_id" name="proveedor_id"
                style="display:block; width:100%; max-width:600px; padding:10px;">
            <option value="">Sin proveedor</option>

            @foreach ($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}"
                    {{ (string) old('proveedor_id', $producto->proveedor_id) === (string) $proveedor->id
                        ? 'selected' : '' }}>
                    {{ $proveedor->nombre }}
                </option>
            @endforeach
        </select>

        <p>* Campos obligatorios.</p>

        <button class="btn" type="submit">Guardar cambios</button>
        <a class="btn btn-secondary"
           href="{{ route('productos.index') }}">Cancelar</a>
    </form>
</div>
@endsection
