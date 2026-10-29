
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Inventario')</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f6f9;
            color: #222;
        }

        header {
            background: #243447;
            color: white;
            padding: 18px 30px;
        }

        header a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }

        main {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px #00000010;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
            border: 0;
            border-radius: 4px;
            background: #2457a7;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-danger { background: #b52b36; }
        .btn-secondary { background: #596575; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th { background: #edf1f5; }

        label {
            display: block;
            margin-top: 14px;
            margin-bottom: 6px;
        }

        input, textarea {
            box-sizing: border-box;
            width: 100%;
            max-width: 600px;
            padding: 10px;
            border: 1px solid #bbb;
            border-radius: 4px;
        }

        .alert {
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 4px;
        }

        .success { background: #d8f3df; }
        .error { color: #a71919; }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .actions form { margin: 0; }

        @media (max-width: 700px) {
            table { font-size: 13px; }
            th, td { padding: 7px; }
            .card { padding: 14px; }
        }
    </style>
</head>
<body>
    <header>
        <strong>Sistema de Inventario</strong>
        <nav style="margin-top: 12px;">
            <a href="{{ route('proveedores.index') }}">Proveedores</a>
            <a href="{{ route('productos.index') }}">Productos</a>
            <a href="{{ route('entradas.index') }}">Entradas</a>
            <a href="{{ route('salidas.index') }}">Salidas</a>
    </header>

    <main>
        @if (session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
