# Sistema de Inventario - La Picá de Yiyo

## Descripción

Sistema web desarrollado para la gestión de inventario del restaurante **La Picá de Yiyo**.

La aplicación permite administrar productos, categorías, usuarios, movimientos de inventario y reportes estadísticos, facilitando el control de stock y la toma de decisiones dentro del restaurante.

---

## Características

### Gestión de Usuarios

* Registro de usuarios.
* Edición de usuarios.
* Eliminación de usuarios.
* Control de acceso mediante roles:

  * Administrador
  * Garzón
  * Cocina

### Gestión de Productos

* Crear productos.
* Editar productos.
* Eliminar productos.
* Asociar productos a categorías.
* Control de stock.
* Control de fechas de vencimiento.

### Gestión de Inventario

* Registro de retiros de productos.
* Historial de movimientos.
* Actualización automática del stock.

### Dashboard

* Ventas mensuales.
* Productos próximos a vencer.
* Productos con stock crítico.
* Productos más retirados.
* Ventas por categoría.

### Reportes

* Historial de movimientos.
* Búsqueda avanzada.
* Ordenamiento por columnas.
* Exportación a PDF.

### Recuperación de Contraseña

* Envío de correo electrónico.
* Restablecimiento seguro de contraseña mediante token.

---

## Tecnologías Utilizadas

### Backend

* Laravel 12
* PHP 8.2

### Frontend

* Laravel Blade
* Bootstrap 5
* JavaScript
* jQuery

### Base de Datos

* MySQL

### Librerías

* Laravel Breeze
* Yajra DataTables
* Chart.js
* DomPDF

---

## Requisitos

* PHP 8.2 o superior
* Composer
* MySQL
* Node.js
* NPM
* XAMPP o servidor Apache

---

## Instalación

### Clonar el repositorio

```bash
git clone URL_DEL_REPOSITORIO
cd NexusSystems
```

### Instalar dependencias

```bash
composer install
npm install
```

### Configurar entorno

Copiar el archivo de ejemplo:

```bash
cp .env.example .env
```

Generar clave:

```bash
php artisan key:generate
```

### Configurar Base de Datos

Editar el archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Lapicadeyiyo
DB_USERNAME=root
DB_PASSWORD=
```

### Ejecutar migraciones

```bash
php artisan migrate:fresh --seed
```


### Compilar assets:

```bash
npm run build
```

### Iniciar:

```bash
php artisan serve
```

---

## Credenciales de Prueba

### Administrador

```text
RUT: 21507579-6
Correo: fernando.arriagada.22@alumnos.uda.cl
Contraseña: 12345678
```
---

## Estructura General

```text
app/
├── Http/
│   ├── Controllers/
│
├── Models/
│
database/
├── migrations/
├── seeders/
│
resources/
├── views/
│   ├── admin/
│   ├── auth/
│   ├── profile/
│
routes/
└── web.php
```

---

## Roles del Sistema

### Administrador

* Gestión completa del sistema.
* Administración de usuarios.
* Gestión de productos.
* Visualización de reportes.

### Garzón

* Registro de retiros.
* Consulta de inventario.

### Cocina

* Consulta de inventario.
* Registro de movimientos autorizados.

---

## Autor

Proyecto desarrollado para la asignatura de Proyecto de Software.

**Equipo NexusSystems**
