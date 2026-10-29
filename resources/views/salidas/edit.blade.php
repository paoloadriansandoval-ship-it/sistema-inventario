
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar salida #{{ $salida->id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('salidas.update', $salida) }}"
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
                            data-existencias="{{ $producto->existencias }}"
                        {{ old('producto_id', $salida->producto_id) == $producto->id ? 'selected' : '' }}>
                        {{ $producto->codigo }} - {{ $producto->nombre }}
                        (Existencias: {{ $producto->existencias }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="stock">Cantidad que saldrá</label>

            <input type="number" name="stock" id="stock"
                   class="form-control" min="1" step="1"
                   value="{{ old('stock', $salida->stock) }}" required>

            <small id="existencias-info" class="form-text text-muted">
                Las existencias se validarán al guardar los cambios.
            </small>
        </div>

        <button type="submit" class="btn btn-primary">
            Actualizar salida
        </button>

        <a href="{{ route('salidas.index') }}"
           class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const producto = document.getElementById('producto_id');
        const cantidad = document.getElementById('stock');
        const informacion = document.getElementById('existencias-info');

        function actualizarExistencias() {
            const opcion = producto.options[producto.selectedIndex];

            if (!opcion || !opcion.value) {
                informacion.textContent = 'Selecciona un producto.';
                cantidad.removeAttribute('max');
                return;
            }

            const existencias = Number(opcion.dataset.existencias);

            informacion.textContent =
                'Existencias actuales del producto: ' + existencias +
                '. La validación final se realizará al guardar.';

            cantidad.max = existencias;
        }

        producto.addEventListener('change', actualizarExistencias);
        actualizarExistencias();
    });
</script>
@endsection
