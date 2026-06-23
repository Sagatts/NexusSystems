<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Movimientos - NexusSystems</title>
    <link rel="stylesheet" href="{{ public_path('css/reportes.css') }}">
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
                <th>Rol / Área</th> <th>Tipo</th>       <th>Cód. Barras</th>
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
                    
                    <td align="center">{{ ucfirst($mov->rol ?? 'N/A') }}</td>
                    
                    <td align="center">
                        @if(strtolower($mov->tipo_movimiento) === 'entrada')
                            <span class="badge-entrada">Entrada</span>
                        @else
                            <span class="badge-salida">Salida</span>
                        @endif
                    </td>
                    
                    <td>{{ $mov->codigo_barras }}</td>
                    <td>{{ $mov->producto }}</td>
                    <td align="center">{{ $mov->cantidad }}</td>
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