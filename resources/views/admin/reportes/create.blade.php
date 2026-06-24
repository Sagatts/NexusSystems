<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Configuración de Reporte de Movimientos
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white pt-3 pb-3">
                <h5 class="fw-bold mb-0">Generador de Reportes</h5>
            </div>
            
            <div class="card-body p-4">
                
                <div class="row">
                    <div class="col-lg-4 border-end pe-lg-4">
                        <p class="text-muted small mb-4">Seleccione las fechas límite para cargar la vista previa del PDF.</p>
                        
                        <form action="{{ route('admin.reportes.exportar') }}" method="GET">
                            
                            <div class="mb-3">
                                <label for="fecha_inicio" class="form-label fw-bold">Fecha Desde</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control shadow-sm">
                                <div id="fecha_inicioError" class="text-danger small mt-1"></div>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_fin" class="form-label fw-bold">Fecha Hasta</label>
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control shadow-sm">
                                <div id="fecha_finError" class="text-danger small mt-1"></div>
                            </div>

                            <button type="button" id="btnVistaPrevia" class="btn btn-corporativo text-white fw-bold shadow-sm w-100 mb-4">
                                <i class="bi bi-eye me-1"></i> Generar Vista Previa
                            </button>

                            <hr>

                            <div class="mb-4 mt-4">
                                <label for="formato" class="form-label fw-bold text-success">Descarga Final</label>
                                <select id="formato" name="formato" class="form-select shadow-sm border-success" required>
                                    <option value="pdf">Documento PDF (.pdf)</option>
                                    <option value="csv">Archivo de Excel / CSV (.csv)</option>
                                </select>
                                <div class="form-text">Si los datos de la derecha están correctos, procede a descargar.</div>
                            </div>

                            <div class="d-flex flex-column gap-2 mt-4">
                                <button type="submit" class="btn btn-success fw-bold shadow-sm">
                                    <i class="bi bi-download me-1"></i> Descargar Archivo
                                </button>
                                <a href="{{ route('admin.reportes.index') }}" class="btn btn-outline-secondary fw-bold shadow-sm">
                                    Cancelar y Volver
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-8 ps-lg-4 mt-4 mt-lg-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold text-secondary mb-0"><i class="bi bi-file-pdf me-2"></i>Vista Previa del Documento</h6>
                            <span id="loadingSpinner" class="spinner-border spinner-border-sm text-info d-none" role="status"></span>
                        </div>
                        
                        <div class="bg-light rounded border d-flex justify-content-center align-items-center w-100" style="height: 600px; overflow: hidden;">
                            <iframe id="iframePdf" class="w-100 h-100 d-none" style="border: none;"></iframe>
                            
                            <div id="mensajeInicial" class="text-center text-muted">
                                <i class="bi bi-file-earmark-text display-4 text-secondary opacity-50"></i>
                                <p class="mt-2 fw-bold">El documento aparecerá aquí</p>
                                <small>Configura las fechas a la izquierda y presiona "Generar Vista Previa"</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            
            function limpiarErrores() {
                $('#fecha_inicio').removeClass('is-invalid');
                $('#fecha_fin').removeClass('is-invalid');
                $('#fecha_inicioError').text('');
                $('#fecha_finError').text('');
            }

            function mostrarError(campo, mensaje) {
                campo.addClass('is-invalid');
                $('#' + campo.attr('id') + 'Error').text(mensaje);
            }

            $('#btnVistaPrevia').click(function() {
                let fechaInicio = $('#fecha_inicio').val();
                let fechaFin = $('#fecha_fin').val();

                if (!fechaInicio || !fechaFin) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Faltan datos',
                        text: 'Por favor, selecciona las fechas para generar el documento.',
                        confirmButtonColor: '#0dcaf0'
                    });
                    return;
                }

                if (fechaInicio > fechaFin) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Fechas incorrectas',
                        text: 'La fecha de inicio no puede ser mayor a la fecha final.',
                        confirmButtonColor: '#dc3545'
                    });
                    return;
                }

                // Mostramos el spinner y ocultamos el mensaje inicial
                $('#loadingSpinner').removeClass('d-none');
                $('#mensajeInicial').addClass('d-none');
                
                // Armamos la URL para el iframe pasándole las fechas por GET
                let urlPrevia = "{{ route('admin.reportes.previa.pdf') }}?fecha_inicio=" + fechaInicio + "&fecha_fin=" + fechaFin;
                
                // Le inyectamos la URL al iframe
                let iframe = $('#iframePdf');
                iframe.attr('src', urlPrevia);
                
                // Cuando el iframe termine de cargar el PDF, quitamos el spinner y lo mostramos
                iframe.on('load', function() {
                    $('#loadingSpinner').addClass('d-none');
                    iframe.removeClass('d-none');
                });
            });

            // Validación al enviar el formulario de descarga
            $('form[action="{{ route('admin.reportes.exportar') }}"]').submit(function(e) {
                limpiarErrores();

                let fechaInicio = $('#fecha_inicio').val();
                let fechaFin = $('#fecha_fin').val();
                let valido = true;

                if (!fechaInicio) {
                    mostrarError($('#fecha_inicio'), 'Debes seleccionar la fecha de inicio.');
                    valido = false;
                }

                if (!fechaFin) {
                    mostrarError($('#fecha_fin'), 'Debes seleccionar la fecha de termino.');
                    valido = false;
                }

                if (fechaInicio && fechaFin && fechaInicio > fechaFin) {
                    mostrarError($('#fecha_inicio'), 'La fecha de inicio no puede ser mayor a la fecha de termino.');
                    valido = false;
                }

                if (!valido) {
                    e.preventDefault();
                }
            });

        });
    </script>
    @endpush
</x-app-layout>