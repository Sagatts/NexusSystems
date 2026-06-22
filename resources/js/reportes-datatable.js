/**
 * DataTable para Reportes/Movimientos
 * Usado en: admin/reportes/index
 */

function initReportesDatatable() {
    if (typeof window.jQuery === 'undefined') {
        setTimeout(initReportesDatatable, 50);
        return;
    }
    if (!$('#tablaMovimientos').length) return;

    $('#tablaMovimientos').DataTable({
        scrollX: true,
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "Todos"]
        ],
        order: [[7, "desc"]],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            search: "Buscar por RUT, Usuario o Producto:"
        },
        columnDefs: [
            { targets: [4, 5, 6], className: "text-center" },
            { targets: 4, searchable: false },
            { targets: 5, searchable: false },
            { targets: 6, searchable: false },
            { targets: 7, searchable: false }
        ]
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReportesDatatable);
} else {
    initReportesDatatable();
}