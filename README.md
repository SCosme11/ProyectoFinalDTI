Aquí tienes una propuesta completa para el archivo `README.md` de tu proyecto, estructurada profesionalmente y basada en el código analizado.

-----

# Cosmos - E-commerce de Astronomía

**Cosmos** es una plataforma de comercio electrónico dedicada a la venta de equipos ópticos y telescopios para astronomía amateur. El proyecto permite a los usuarios explorar un catálogo, gestionar un carrito de compras y realizar pedidos, mientras ofrece a los administradores herramientas para gestionar el inventario y las ventas.

## Características Principales

### Usuarios (Clientes)

  * **Autenticación:** Sistema de registro e inicio de sesión seguro con hash de contraseñas.
  * **Catálogo Interactivo:** Visualización de productos con paginación y detalles completos (imágenes, descripciones, stock).
  * **Carrito de Compras:** Funcionalidad para añadir productos, actualizar cantidades dinámicamente según el stock disponible y eliminar ítems.
  * **Perfil de Usuario:** Gestión de información personal, dirección de envío y visualización del historial de compras con imágenes de los productos adquiridos.

### Administrador

  * **Panel de Control:** Acceso restringido para la gestión de la tienda.
  * **Gestión de Inventario:**
      * Agregar nuevos productos con imágenes.
      * Editar detalles y stock de productos existentes.
      * Eliminar productos (con validación de integridad referencial para no borrar historial de ventas).
  * **Reportes:** Visualización global de todas las ventas realizadas en la plataforma.

-----

## Tecnologías Utilizadas

El proyecto está dockerizado y utiliza las siguientes tecnologías:

  * **Lenguaje:** PHP 8.2 (Apache).
  * **Base de Datos:** MySQL 8.1.0.
  * **Frontend:**
      * HTML5 / CSS3 (Estilos personalizados `index.css`).
      * **Bootstrap 5.3** para diseño responsivo y componentes.
      * **SweetAlert2** para alertas interactivas.
  * **Infraestructura:** Docker y Docker Compose.

-----

## Instalación y Despliegue

Este proyecto utiliza Docker para facilitar el despliegue.

### Prerrequisitos

  * Tener instalado **Docker** y **Docker Compose**.

### Pasos para ejecutar

1.  Clona el repositorio.

2.  Navega a la carpeta raíz del proyecto (donde se encuentra el `docker-compose.yml`).

3.  Ejecuta el siguiente comando en tu terminal:

    ```bash
    docker-compose up -d
    ```

4.  Accede a la aplicación desde tu navegador:

      * **Web:** `http://localhost:8080`
      * **phpMyAdmin:** `http://localhost:8081`

### Configuración de la Base de Datos

La conexión ya está configurada automáticamente en el archivo `html/db.php` para funcionar con el contenedor de Docker:

  * **Host:** `db`
  * **Usuario:** `root`
  * **Contraseña:** `root_password`
  * **Base de datos:** `tienda`

> **Nota:** La carpeta `mysql_data/` se crea automáticamente para persistir los datos de la base de datos.

-----

## Acceso Administrativo

El sistema detecta automáticamente al administrador basándose en el correo electrónico. Para acceder a las funciones de administrador (`/html/admin.php`), el usuario debe registrarse o iniciar sesión con:

  * **Correo:** `admin@cosmos.com`
  * **Contraseña:** `Admin123`
  * **Rol:** El sistema asigna internamente el permiso `es_admin = true` a este correo específico.

-----

## Estructura del Proyecto

```text
/
├── css/                  # Estilos personalizados (index.css)
├── html/                 # Código fuente PHP
│   ├── admin.php         # Panel de administración
│   ├── carrito.php       # Vista del carrito
│   ├── db.php            # Conexión a Base de Datos
│   ├── login.php         # Login de usuarios
│   ├── usuario.php       # Perfil e historial
│   └── ... (otros scripts lógicos y vistas)
├── img/                  # Imágenes del sitio (Logo, banners)
├── mysql_data/           # Persistencia de BD (ignorado por git)
├── docker-compose.yml    # Orquestación de contenedores
└── index.php             # Página de inicio y catálogo
```

-----

## Notas Adicionales

  * **Integridad de Datos:** El sistema impide eliminar productos que ya han sido comprados por usuarios para no romper el historial de ventas, mostrando una alerta específica.
  * **Manejo de Imágenes:** Las imágenes de los productos se almacenan directamente en la base de datos como contenido binario (BLOB).
