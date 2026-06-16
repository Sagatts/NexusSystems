<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Configuración de Reporte de Movimientos
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-4" style="max-width: 700px; margin: 0 auto;">
            <div class="card-header bg-white pt-3 pb-3">
                <h5 class="fw-bold mb-0">Parámetros de Filtrado</h5>
            </div>
            
            <div class="card-body p-4">
                <p class="text-muted small mb-4">Seleccione las fechas límite y el formato de salida para el historial de movimientos.</p>
                
                <form action="{{ route('admin.reportes.exportar') }}" method="GET">
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="form-label fw-bold">Fecha Desde</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                        </div>

                        <div class="col-md-6 mt-3 mt-md-0">
                            <label for="fecha_fin" class="form-label fw-bold">Fecha Hasta</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="formato" class="form-label fw-bold">Formato del Archivo</label>
                        <select id="formato" name="formato" class="form-select" required>
                            <option value="pdf">Documento PDF (.pdf)</option>
                            <option value="csv">Archivo de Excel / CSV (.csv)</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('admin.reportes.index') }}" class="btn btn-outline-secondary fw-bold">
                            Volver al Historial
                        </a>
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="bi bi-file-earmark-arrow-down-fill me-1"></i>
                            Descargar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>