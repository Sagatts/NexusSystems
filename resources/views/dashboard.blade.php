<x-app-layout>
    <x-slot name="header">
        <h2 style="font-weight: 600; font-size: 1.25rem; color: #1f2937; margin: 0;">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           ¡Bienvenido, {{ trim(Auth::user()->nombre) }}!
     </h2>
    <div class="dashboard-wrapper">
        
        <div class="dashboard-top-wrapper">
            <span class="dashboard-box-title">Gestor de reportes</span>
            
            <div class="dashboard-top-container">
                <canvas id="graficoVentas"></canvas>
            </div>
        </div>

        <div class="dashboard-grid">
            
            <div class="dashboard-box-wrapper">
                <span class="dashboard-box-title">Gestión de productos</span>
                <div class="dashboard-box">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Foto</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Foto</td>
                                <td>Carne</td>
                                <td>$6767</td>
                                <td>45</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Foto</td>
                                <td>Choclo</td>
                                <td>$100</td>
                                <td>12</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Foto</td>
                                <td>Vienesas</td>
                                <td>$500</td>
                                <td>30</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Foto</td>
                                <td>Papas</td>
                                <td>$50</td>
                                <td>8</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Foto</td>
                                <td>Arroz</td>
                                <td>$999</td>
                                <td>8</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Foto</td>
                                <td>Fideos</td>
                                <td>$999</td>
                                <td>4</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="dashboard-box-wrapper">
                <span class="dashboard-box-title">Gestión de usuarios</span>
                <div class="dashboard-box">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>RUT</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Rol</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>123</td>
                                <td>Juan</td>
                                <td>Pérez</td>
                                <td>Cocina</td>
                                <td><span class="badge active">Activo</span></td>
                            </tr>
                            <tr>
                                <td>456</td>
                                <td>María</td>
                                <td>Soto</td>
                                <td>Garzón</td>
                                <td><span class="badge active">Activo</span></td>
                            </tr>
                            <tr>
                                <td>789</td>
                                <td>Pedro</td>
                                <td>Diaz</td>
                                <td>Garzón</td>
                                <td><span class="badge inactive">Inactivo</span></td>
                            </tr>
                            <tr>
                                <td>1234567-8</td>
                                <td>Ana</td>
                                <td>Vega</td>
                                <td>Cocina</td>
                                <td><span class="badge active">Activo</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('graficoVentas').getContext('2d');
            
            new Chart(ctx, {
                type: 'line', // Tipo de gráfico (líneas)
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio'],
                    datasets: [{
                        label: 'Ventas Mensuales',
                        data: [120, 190, 150, 220, 180, 250, 300], // Datos falsos
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 3,
                        tension: 0.4, 
                        fill: true 
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
    </x-slot>
</x-app-layout>