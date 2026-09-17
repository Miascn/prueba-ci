# Sistema de Ventas en CodeIgniter 4

Sistema web básico desarrollado con **PHP 8 + CodeIgniter 4 + MySQL + Bootstrap 5**, ideal para pruebas técnicas y demostraciones de desarrollo web backend/fullstack.

Incluye:
* **Autenticación**: Login y Logout con sesiones y contraseñas cifradas.
* **CRUD de Clientes**: Crear, listar, editar y eliminar clientes.
* **CRUD de Productos**: Control de catálogo, precios y existencias (stock).
* **Módulo de Ventas**: Registro de venta con selección de cliente, producto, cantidad, cálculo de total y descuento automático de inventario.
* **Historial y Comprobante**: Detalle de venta y opción para anular venta (restaura el stock).
* **Dashboard**: Resumen de totales (clientes, productos, ventas e ingresos).

---

## 1. Comandos Frecuentes (Terminal / Spark)

### Servidor de Desarrollo
```bash
# Iniciar el servidor local en el puerto 8080
php spark serve --port 8080

# Iniciar en el puerto por defecto (8080)
php spark serve
```

### Base de Datos y Migraciones
```bash
# Ejecutar las migraciones (crear las tablas)
php spark migrate

# Revertir y volver a ejecutar las migraciones desde cero
php spark migrate:refresh

# Poblar la base de datos con datos de prueba (admin, clientes, productos)
php spark db:seed InitialSeeder

# Ver el estado de las migraciones
php spark migrate:status
```

### Rutas e Inspección
```bash
# Listar todas las rutas registradas y sus filtros aplicados
php spark routes

# Generar una nueva clave de cifrado en el archivo .env
php spark key:generate
```

### Generadores Rápidos de Código (Scaffolding de Spark)
```bash
# Crear un nuevo controlador
php spark make:controller NombreController

# Crear un nuevo modelo
php spark make:model NombreModel

# Crear una nueva migración
php spark make:migration NombreMigracion

# Crear un nuevo seeder
php spark make:seeder NombreSeeder
```

### Comandos Git
```bash
# Ver estado de los archivos modificados
git status

# Agregar cambios al área de preparación (stage)
git add .

# Crear commit con mensaje
git commit -m "Descripción de los cambios"

# Subir cambios al repositorio remoto
git push origin main
```

---

## 2. Preguntas Típicas de Entrevista Técnica y Respuestas

### P1: ¿Cómo funciona el flujo de trabajo MVC en CodeIgniter 4?
> **Respuesta:**
> "La petición HTTP entra por `public/index.php`. El enrutador (`app/Config/Routes.php`) analiza la URL y ejecuta los filtros correspondientes (como `AuthFilter` para comprobar si el usuario inició sesión). Luego, la petición se envía al método del **Controlador** (ej. `Clientes::index`). El controlador invoca al **Modelo** (`ClienteModel`) para consultar la base de datos y finalmente le pasa los datos a la **Vista** (`clientes/index.php`) para renderizar el HTML que ve el usuario."

### P2: ¿Cómo protegiste las rutas privadas para que nadie entre sin iniciar sesión?
> **Respuesta:**
> "Creé un filtro en `app/Filters/AuthFilter.php` que evalúa `if (!session()->get('logged_in'))`. Si no hay sesión activa, redirige automáticamente a `/login`. En `app/Config/Filters.php` registré el alias `'auth'` y en `app/Config/Routes.php` agrupé todas las rutas protegidas (`/`, `/clientes`, `/productos`, `/ventas`) bajo el atributo `['filter' => 'auth']`."

### P3: ¿Cómo se almacenan y verifican las contraseñas de los usuarios?
> **Respuesta:**
> "Nunca se guardan en texto plano. Se utiliza la función nativa de PHP `password_hash($password, PASSWORD_DEFAULT)` al crear el usuario (utiliza el algoritmo seguro Bcrypt). Al momento del login, tomo la contraseña escrita por el usuario y la comparo contra el hash de la base de datos usando `password_verify($password, $user['password'])`."

### P4: ¿Cómo controlas el stock cuando se realiza una venta?
> **Respuesta:**
> "En el método `guardar()` de `Ventas`:
> 1. Busco el producto por su ID y valido si hay suficiente inventario: `if ($producto['stock'] < $cantidad)`. Si no alcanza, devuelvo un error.
> 2. Si hay stock, inserto la venta en `ventas` y el registro en `detalle_ventas`.
> 3. Descuento las unidades vendidas actualizando el producto: `$productModel->update($id, ['stock' => $producto['stock'] - $cantidad])`.
> 4. Si la venta se llega a anular en `eliminar()`, recorro los detalles y le devuelvo las unidades al stock del producto."

### P5: ¿Para qué sirve la propiedad `$allowedFields` en los modelos de CodeIgniter?
> **Respuesta:**
> "Sirve como medida de seguridad contra ataques de **Asignación Masiva (Mass Assignment)**. En `$allowedFields` listamos únicamente los campos de la tabla que permitimos que se puedan guardar o actualizar desde peticiones del usuario. Si alguien intenta inyectar campos no autorizados (como `id` o cambiar su rol), CodeIgniter los ignora automáticamente."

### P6: ¿Cómo proteges los formularios contra ataques CSRF?
> **Respuesta:**
> "Dentro de cada etiqueta `<form method=\"POST\">` se coloca la función `<?= csrf_field() ?>`. Esto genera un campo oculto con un token criptográfico único. CodeIgniter valida automáticamente que el token coincida con el de la sesión actual antes de procesar la petición POST."

### P7: ¿Dónde se configuran las credenciales de la base de datos y por qué no están en Git?
> **Respuesta:**
> "Se configuran en el archivo `.env` en la raíz del proyecto (`database.default.hostname`, `database.default.database`, `database.default.username`, `database.default.password`). Este archivo está incluido en `.gitignore` para evitar que credenciales y contraseñas sensibles se suban al repositorio público o privado."

### P8: ¿Qué es un Seeder (Semillero), para qué sirve y en qué se diferencia de una Migración?
> **Respuesta:**
> "Un **Seeder** es una clase en `app/Database/Seeds/` que sirve para poblar o alimentar la base de datos con datos automáticamente. Se utiliza para:
> 1. Crear datos iniciales obligatorios del sistema (como el usuario administrador inicial o roles).
> 2. Insertar datos de prueba (dummy data) para poder probar el sistema sin tener que registrar clientes y productos a mano uno por uno.
>
> **Diferencia clave con una Migración:**
> * La **Migración** gestiona la **estructura** de la base de datos (crea, modifica o elimina tablas, columnas y tipos de datos - DDL).
> * El **Seeder** gestiona el **contenido** (inserta los registros dentro de esas tablas usando `$this->db->table('tabla')->insertBatch([...])` - DML).
>
> **Cómo se ejecuta:** Con el comando `php spark db:seed InitialSeeder`."

---

## 3. Credenciales y Datos de Prueba

* **URL del Sistema:** `http://localhost:8080/login`
* **Usuario:** `admin`
* **Contraseña:** `admin123`

### Estructura de la Base de Datos (`prueba_ci`):
* `usuarios`: id, nombre, usuario, password, rol, created_at, updated_at.
* `clientes`: id, documento, nombre, telefono, email, direccion, created_at, updated_at.
* `productos`: id, codigo, nombre, descripcion, precio, stock, created_at, updated_at.
* `ventas`: id, numero_factura, cliente_id, usuario_id, total, fecha, created_at, updated_at.
* `detalle_ventas`: id, venta_id, producto_id, cantidad, precio_unitario, subtotal.
