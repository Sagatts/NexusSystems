<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Movimientos - NexusSystems</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #dc3545; /* Rojo corporativo */
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .info-auditoria {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-auditoria td {
            padding: 4px;
            font-size: 11px;
        }
        .tabla-datos {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .tabla-datos th, .tabla-datos td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        .tabla-datos th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Reporte Histórico de Movimientos</h2>
    </div>

    <table class="info-auditoria">
        <tr>
            <td><strong>Generado por:</strong> {{ $generado_por }}</td>
            <td><strong>Fecha de Emisión:</strong> {{ $fecha }}</td>
        </tr>
        <tr>
            <td><strong>Período del Reporte:</strong> {{ $fecha_inicio }} al {{ $fecha_fin }}</td>
            <td><strong>Hora:</strong> {{ $hora }} ({{ $dia }})</td>
        </tr>
    </table>

    <table class="tabla-datos">
        <thead>
            <tr>
                <th>RUT</th>
                <th>Usuario</th>
                <th>Cód. Barras</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Fecha y Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $mov)
                <tr>
                    <td>{{ $mov->rut }}</td>
                    <td>{{ $mov->usuario }}</td>
                    <td>{{ $mov->codigo_barras }}</td>
                    <td>{{ $mov->producto }}</td>
                    <td style="text-align: center;">{{ $mov->cantidad }}</td>
                    <td>${{ number_format($mov->precio_neto * $mov->cantidad, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($mov->fecha_hora)->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Documento generado automáticamente por el sistema de inventario.
    </div>

</body>
</html>