<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Reportes
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
    
    <!-- 1. CONTENEDORES SUPERIORES -->
    <div class="row mb-4">
        <!-- Contenedor Izquierdo -->
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="border border-2 rounded bg-light w-100" style="height: 250px;">
                <!-- Aquí irá el gráfico de barras en el futuro -->
            </div>
        </div>
        
        <!-- Contenedor Derecho -->
        <div class="col-md-6">
            <div class="border border-2 rounded bg-light w-100" style="height: 250px;">
                <!-- Aquí irá el gráfico circular en el futuro -->
            </div>
        </div>
    </div>

    <!-- TÍTULO Y BOTÓN DE REPORTE -->
    <div class="border border-2 rounded bg-white p-4">
        
        <div class="d-flex justify-content-between align-items-end mb-3">
            <h5 class="text-dark mb-0 fw-normal">Historial de movimientos:</h5>
            
            <button class="btn btn-light border border-secondary d-flex align-items-center text-dark fw-medium">
                Generar Reporte
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="ms-2" viewBox="0 0 16 16">
                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                </svg>
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="fw-semibold">RUT <span class="text-secondary ms-2" style="font-size: 0.8em;">♦</span></th>
                        <th scope="col" class="fw-semibold">Código Barras <span class="text-secondary ms-2" style="font-size: 0.8em;">♦</span></th>
                        <th scope="col" class="fw-semibold">Nombre Usuario <span class="text-secondary ms-2" style="font-size: 0.8em;">♦</span></th>
                        <th scope="col" class="fw-semibold">Nombre Producto <span class="text-secondary ms-2" style="font-size: 0.8em;">♦</span></th>
                        <th scope="col" class="fw-semibold">Precio <span class="text-secondary ms-2" style="font-size: 0.8em;">♦</span></th>
                        <th scope="col" class="fw-semibold">Hora de movimiento <span class="text-secondary ms-2" style="font-size: 0.8em;">♦</span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>

</div>

</x-app-layout>

