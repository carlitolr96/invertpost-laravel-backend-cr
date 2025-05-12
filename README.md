# 🧪 Ejercicio 2: Backend en PHP y Laravel

Este proyecto es una API RESTful desarrollada con Laravel para la gestión de un almacén, incluyendo clientes, artículos, usuarios y pedidos. Incluye consultas API 

---

## 📋 Requisitos

- PHP 8.x  
- Laravel 9.x  
- SQLite
- Composer  
- PHPUnit  
- Node.js y npm (opcional, para assets frontend)

---

## 🚀 Instalación

1. **Clona el repositorio**
   ```bash
   git clone https://github.com/carlitolr96/invertpost-laravel-backend-cr.git
   cd invertpost-laravel-backend-cr
   ```

2. **Instala las dependencias**
   ```bash
   composer install
   ```

3. **Copia el archivo `.env`**
   ```bash
   cp .env.example .env
   ```

4. **Configura tus credenciales de base de datos** en `.env`:
   ```dotenv
    DB_CONNECTION=sqlite
    DB_DATABASE=\Users\enman\almacen_api\database\database.sqlite
   ```

5. **Genera la clave de la aplicación**
   ```bash
   php artisan key:generate
   ```

6. **Ejecuta las migraciones**
   ```bash
   php artisan migrate
   ```

7. **(Opcional) Compila assets frontend**
   ```bash
   npm install
   npm run dev
   ```

8. **Inicia el servidor**
   ```bash
   php artisan serve
   ```

---

## 🛠 Estructura del Proyecto

- `TblCliente` – Registro de clientes  
- `TblArticulo` – Registro de artículos  
- `TblColocacion` – Colocaciones de productos  
- `TblPedido` – Registro de pedidos  
- `TblFactura` – Facturación  
- `TblPY1` – Registro de usuarios (empleados)

---

## 📦 Endpoints de la API

> Todos los endpoints devuelven respuestas JSON.

### Productos
```
POST   /api/productos          → Crear producto  
GET    /api/productos          → Listar productos (con filtros y paginación)  
GET    /api/productos/{id}     → Mostrar un producto  
PUT    /api/productos/{id}     → Actualizar producto  
DELETE /api/productos/{id}     → Eliminar producto
```

### Clientes, Usuarios y Pedidos tienen rutas similares:
```
/api/clientes
/api/usuarios
/api/pedidos
```

---

## 🔍 Filtros y Paginación

Puedes aplicar filtros en los listados mediante query parameters:

```http
GET /api/productos?nombre=camisa&precio_min=10&precio_max=50&stock_min=5&page=1&per_page=10
```

**Parámetros disponibles:**
- `nombre`
- `precio_min`, `precio_max`
- `stock_min`, `stock_max`
- `per_page`, `page`

La respuesta incluye:
```json
{
  "data": [...],
  "total": 45,
  "per_page": 10,
  "current_page": 1,
  "last_page": 5
}
```

---

## ✅ Pruebas Unitarias

1. Ejecuta todas las pruebas con:
   ```bash
   php artisan test
   ```

2. Las pruebas se ubican en `tests/Feature` y cubren:
   - CRUD completo para cada entidad
   - Validaciones incorrectas
   - Filtros y paginación

---

## 🧩 Diseño de la Base de Datos

### Clientes (`tblcliente`)
- `id`, `nombre`, `telefono`, `tipo_cliente`, `created_at`

### Artículos (`tblarticulo`)
- `id`, `nombre`, `descripcion`, `fabricante`

### Colocaciones (`tblcolocacion`)
- `id`, `articulo_id`, `precio`, `nombre`

### Pedidos (`tblpedido`)
- `id`, `cliente_id`, `colocacion_id`, `unidades`

### Facturas (`tblfactura`)
- `id`, `cliente_id`, `fecha`, `total`

### Usuarios (`tblPY1`)
- `id`, `nombre`, `cedula`, `telefono`, `tipo_sangre`, `email`, `password`

---

## 🧠 Buenas Prácticas

- Separación clara de responsabilidades: modelos, controladores, validaciones.
- Respuestas JSON consistentes y con código de estado HTTP.
- Cobertura de pruebas para controladores y validaciones.

---

## 📌 Autor

- Carlos Luis Lachapell Rivera
- carlosluis9631@gmail.com
- GitHub: [https://github.com/carlitolr96](https://github.com/carlitolr96/invertpost-laravel-backend-cr.git)

---