
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar entrada #{{ $entrada->id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('entradas.update', $entrada) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="producto_id">Producto</label>

            <select name="producto_id" id="producto_id"
                    class="form-control" required>
                <option value="">Selecciona un producto</option>

                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}"
                        {{ old('producto_id', $entrada->producto_id) == $producto->id ? 'selected' : '' }}>
                        {{ $producto->codigo }} - {{ $producto->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="proveedor_id">Proveedor (opcional)</label>

            <select name="proveedor_id" id="proveedor_id"
                    class="form-control">
                <option value="">Sin proveedor</option>

                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}"
                        {{ old('proveedor_id', $entrada->proveedor_id) == $proveedor->id ? 'selected' : '' }}>
                        {{ $proveedor->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="stock">Cantidad recibida</label>

            <input type="number" name="stock" id="stock"
                   class="form-control" min="1" step="1"
                   value="{{ old('stock', $entrada->stock) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">
            Actualizar entrada
        </button>

        <a href="{{ route('entradas.index') }}"
           class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>
@endsection
