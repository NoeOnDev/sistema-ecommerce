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
   git clone https://github.com/NoeOnDev/sistema-ecommerce.git
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

## Carrito de Compras

El sistema incluye un completo carrito de compras con las siguientes características:

### Funcionalidades del Carrito

- **Persistencia dual**: Funciona tanto para usuarios autenticados (almacenamiento en base de datos) como para visitantes (almacenamiento en sesión)
- **Fusión automática**: Al iniciar sesión, los productos del carrito de sesión se transfieren automáticamente al carrito del usuario
- **Gestión de productos**: Permite añadir, actualizar cantidades y eliminar productos
- **Cálculos automáticos**: Calcula subtotales por ítem, subtotal del carrito, impuestos y total

### Estructura de Datos

- **Cart**: Modelo principal que almacena información del carrito
  - Asociado a un usuario (para usuarios autenticados)
  - Asociado a un ID de sesión (para visitantes)
  - Almacena la tasa de impuesto aplicable
  
- **CartItem**: Productos específicos en el carrito
  - Cantidad de cada producto
  - Precio al momento de añadir (para mantener consistencia ante cambios de precio)

### Interfaz de Usuario

- Indicador visual en la barra de navegación que muestra la cantidad de productos en el carrito
- Vista detallada del carrito con imágenes de productos, precios, cantidades y subtotales
- Selector de cantidad que actualiza automáticamente al cambiar
- Cálculo en tiempo real de subtotales, impuestos y total de la compra

### Pruebas

El sistema de carrito está completamente probado mediante tests que verifican:
- Adición de productos por usuarios autenticados y visitantes
- Actualización de cantidades
- Eliminación de productos individuales
- Vaciado completo del carrito
- Cálculo correcto de subtotales, impuestos y totales
- Fusión de carritos al iniciar sesión

## Proceso de Checkout

El sistema incluye un flujo completo de checkout que permite a los usuarios finalizar sus compras de manera intuitiva:

### Arquitectura del Checkout

El proceso de checkout está diseñado como un flujo de tres pasos:

1. **Revisión del Carrito**: Visualización detallada de los productos seleccionados, cantidades, precios y totales.
2. **Información de Envío**: Formulario para los datos de entrega del pedido.
3. **Método de Pago**: Opciones de pago y finalización de la compra.

### Características del Checkout

- **Experiencia de usuario fluida**: Navegación clara entre pasos con indicadores visuales.
- **Validación en cada paso**: Verificaciones para asegurar que los datos necesarios están completos.
- **Resumen del pedido**: Mostrado en cada paso para que el usuario siempre tenga presente su compra.
- **Múltiples métodos de pago**: Soporte para tarjetas de crédito, PayPal y transferencias bancarias.
- **Simulación de pago**: Sistema que simula el procesamiento del pago para fines de demostración.
- **Confirmación inmediata**: Página de confirmación con detalles completos del pedido.

### Seguridad y Validación

- Verificaciones para prevenir acceso no autorizado a las páginas de checkout
- Validación de stock en tiempo real antes de confirmar el pedido
- Protección de rutas sensibles mediante middleware de autenticación
- Transacciones de base de datos para garantizar la integridad de los datos del pedido

### Proceso de Compra

1. El usuario revisa los productos en su carrito
2. Proporciona la información de envío
3. Selecciona un método de pago e ingresa los datos necesarios
4. Recibe confirmación de su pedido
5. El sistema actualiza automáticamente el inventario

## Seguridad y Auditoría

El sistema implementa un protocolo AAA completo:

### Autenticación

- Sistema de login basado en Laravel Breeze
- Verificación de correo electrónico para nuevos registros
- Protección contra ataques de fuerza bruta

### Autorización

- Sistema de roles (admin, cliente)
- Middleware personalizado para verificación de roles (`role:admin`)
- Protección de rutas sensibles

### Auditoría

El sistema cuenta con un mecanismo robusto de auditoría para rastrear acciones críticas:

- **Canal dedicado**: Los eventos de auditoría se almacenan en archivos separados (`storage/logs/audit/audit.log`)
- **Rotación diaria**: Los logs se mantienen por 30 días y se rotan diariamente
- **Eventos monitoreados**:
  - Cambios en precios de productos
  - Modificaciones en niveles de inventario
  - Creación y eliminación de productos
  - Procesamiento de órdenes y pagos
  - Errores en transacciones críticas

#### Estructura de los logs de auditoría

Cada entrada de log incluye:
- Usuario que realizó la acción
- Fecha y hora
- Tipo de acción
- Entidad afectada
- Datos anteriores y nuevos valores
- Dirección IP
- User-Agent

#### Consulta de logs

Los administradores pueden consultar los logs de auditoría accediendo directamente a los archivos en `storage/logs/audit/` o implementando un visor de logs mediante herramientas como Laravel Telescope o un dashboard personalizado.

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

### Página de Inicio
![Página de Inicio](public/images/landing.png "Página de Inicio")

### Lista de productos
![Lista de productos](public/images/index_products.png "Lista de productos")

### Mostrar producto
![Mostrar producto](public/images/show_produc.png "Mostrar producto")

### Carrito de compras
![Carrito de compras](public/images/step_1_checkout.png "Carrito de compras")

### Paso 2 de pasarela de pago
![Paso 2 de pasarela de pago](public/images/step_2_checkout.png "Paso 2 de pasarela de pago")

### Paso 3 de pasarela de pago
![Paso 3 de pasarela de pago](public/images/step_3_checkout.png "Paso 3 de pasarela de pago")

### Compra éxitosa
![Compra éxitosa](public/images/end_checkout.png "Compra éxitosa")


## Licencia

Este proyecto está bajo la Licencia MIT.
