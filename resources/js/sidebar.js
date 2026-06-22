/**
 * Toggle del Sidebar
 * Usado en: layouts/app
 */

document.addEventListener("DOMContentLoaded", function() {
    const btnBurger = document.getElementById("btnBurger");
    const btnClose = document.getElementById("closeSidebarBtn");
    const sidebar = document.getElementById("sidebar");

    // Restaurar estado del sidebar
    if (sidebar && localStorage.getItem("barra_achicada") === "true") {
        sidebar.classList.add("collapsed");
    }

    function toggleSidebar() {
        if (!sidebar) return;

        sidebar.classList.toggle("collapsed");

        if (sidebar.classList.contains("collapsed")) {
            localStorage.setItem("barra_achicada", "true");
        } else {
            localStorage.setItem("barra_achicada", "false");
        }
    }

    if (sidebar) {
        if (btnBurger) {
            btnBurger.addEventListener("click", toggleSidebar);
        }

        if (btnClose) {
            btnClose.addEventListener("click", toggleSidebar);
        }
    }
});