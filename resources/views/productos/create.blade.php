@extends('layouts.app')

@section('title', 'Registrar producto')

@section('content')
<div class="card">
    <h1>Registrar producto</h1>

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

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf

        <label for="codigo">Código *</label>
        <input id="codigo" name="codigo" type="text"
               value="{{ old('codigo') }}" maxlength="50" required>

        <label for="nombre">Nombre del producto *</label>
        <input id="nombre" name="nombre" type="text"
               value="{{ old('nombre') }}" maxlength="150" required>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion"
                  rows="3">{{ old('descripcion') }}</textarea>

        <label for="precio">Precio unitario *</label>
        <input id="precio" name="precio" type="number"
               min="0" step="0.01"
               value="{{ old('precio', '0.00') }}" required>

        <label for="existencias">Existencias iniciales *</label>
        <input id="existencias" name="existencias" type="number"
               min="0" step="1"
               value="{{ old('existencias', 0) }}" required>

        <label for="stock_minimo">Stock mínimo *</label>
        <input id="stock_minimo" name="stock_minimo" type="number"
               min="0" step="1"
               value="{{ old('stock_minimo', 5) }}" required>

        <label for="proveedor_id">Proveedor</label>
        <select id="proveedor_id" name="proveedor_id"
                style="display:block; width:100%; max-width:600px; padding:10px;">
            <option value="">Sin proveedor</option>

            @foreach ($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}"
                    {{ (string) old('proveedor_id') === (string) $proveedor->id
                        ? 'selected' : '' }}>
                    {{ $proveedor->nombre }}
                </option>
            @endforeach
        </select>

        <p>* Campos obligatorios.</p>

        <button class="btn" type="submit">Guardar producto</button>
        <a class="btn btn-secondary"
           href="{{ route('productos.index') }}">Cancelar</a>
    </form>
</div>
@endsection
