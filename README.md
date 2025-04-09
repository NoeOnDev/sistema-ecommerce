# Sistema E-commerce Laravel

Este proyecto implementa un sistema de gestión de productos para e-commerce utilizando Laravel.

## Características

- **Gestión completa de productos (CRUD)**
- **Categorización** de productos
- **Etiquetado** para mejorar la búsqueda
- **Carga de imágenes** para productos
- **Búsqueda y filtrado** avanzado

## Requisitos

- PHP >= 8.1
- Composer
- MySQL o SQLite
- Node.js y NPM (para los assets)
- Extensión GD de PHP (para manejo de imágenes)

## Instalación

1. Clonar el repositorio:

   ```bash
   git clone https://github.com/tu-usuario/sistema-ecommerce.git
   cd sistema-ecommerce
   ```

2. Instalar dependencias:

   ```bash
   composer install
   npm install
   npm run build
   ```

3. Configurar el entorno:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configurar la base de datos en el archivo `.env`

5. Ejecutar migraciones y seeders:

   ```bash
   php artisan migrate --seed
   ```

6. Crear enlace simbólico para el almacenamiento:

   ```bash
   php artisan storage:link
   ```

7. Iniciar el servidor:

   ```bash
   php artisan serve
   ```

## Estructura del Proyecto

### Modelos

El proyecto utiliza los siguientes modelos:

- **Product**: Representa un producto con propiedades como nombre, descripción, precio, etc.
- **Category**: Permite clasificar los productos en categorías.
- **Tag**: Permite asignar etiquetas a los productos para facilitar la búsqueda.

### Relaciones entre Modelos

- Un `Product` pertenece a una `Category` (relación muchos a uno)
- Un `Product` puede tener muchos `Tag` y un `Tag` puede estar asociado a muchos `Product` (relación muchos a muchos)

## Funcionalidades

### Gestión de Productos

- **Listar productos**: Visualización paginada con opciones de búsqueda y filtro.
- **Ver detalles**: Información completa de un producto con su imagen, categoría y etiquetas.
- **Crear productos**: Formulario con validación para añadir nuevos productos con imágenes.
- **Editar productos**: Actualización de cualquier propiedad de un producto existente.
- **Eliminar productos**: Eliminación de productos con confirmación.

### Búsqueda y Filtrado

- Búsqueda por nombre de producto
- Filtrado por categoría

## Autenticación y Roles

El sistema cuenta con autenticación completa mediante Laravel Breeze:

- **Registro de usuarios**: Los usuarios pueden registrarse proporcionando nombre, email y contraseña.
- **Verificación de email**: Los nuevos usuarios deben verificar su email para acceder a funcionalidades protegidas.
- **Roles de usuario**: El sistema implementa dos roles:
  - **Admin**: Acceso completo a todas las funcionalidades del sistema.
  - **Cliente**: Acceso limitado a visualización de productos y gestión de su perfil.

### Sistema de permisos

El control de acceso se implementa mediante middleware:

- El middleware `auth` protege rutas que requieren autenticación.
- El middleware `verified` asegura que el usuario haya verificado su email.
- El middleware `role:admin` restringe el acceso solo a administradores.

### Usuarios predeterminados

El sistema se instala con un usuario administrador predefinido:

- Email: admin@example.com
- Contraseña: password

Para crear más administradores, se puede modificar un usuario existente en la base de datos o usar el siguiente comando:

```bash
php artisan tinker
User::where('email', 'correo@ejemplo.com')->update(['role' => 'admin'])
```

## Pruebas

El proyecto incluye pruebas unitarias y funcionales que verifican que todas las funcionalidades están trabajando correctamente:

```bash
php artisan test
```

Las pruebas cubren:

- Modelo de Producto: atributos fillable, relaciones con categorías y etiquetas
- Controlador de Productos: operaciones CRUD completas
- Filtros y búsqueda: funcionalidad de filtrado por nombre y categoría
- Configuración del sistema: paginación con Bootstrap

> **Nota**: Las advertencias sobre metadatos en comentarios doc (`/** @test */`) son normales y no afectan la funcionalidad de las pruebas. En versiones futuras de PHPUnit (v12+), se deberá migrar a usar atributos de PHP (`#[Test]`).

### Requisitos para pruebas

Para ejecutar las pruebas que involucran imágenes, necesitas tener instalada la extensión GD de PHP:

```bash
# En sistemas basados en Debian/Ubuntu
sudo apt-get install php8.1-gd  # Ajusta la versión según tu instalación de PHP

# En sistemas basados en RHEL/CentOS
sudo yum install php-gd

# En macOS con Homebrew
brew install php@8.1  # Normalmente GD viene incluido
```

## Capturas de Pantalla

(Aquí puedes incluir algunas capturas de la aplicación)

## Licencia

Este proyecto está bajo la Licencia MIT.
