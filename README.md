# 🍽️ ProvenSoft Restaurant

Aplicación web de gestión de restaurante desarrollada en PHP con Bootstrap 5. Sistema completo de autenticación, gestión de menús y control de acceso por roles (usuario/administrador).

## 📋 Descripción

**ProvenSoft Restaurant** es una aplicación web que permite gestionar los menús de un restaurante. Los usuarios pueden consultar el menú del día y el menú completo, mientras que los administradores tienen acceso a funcionalidades adicionales para gestionar tanto menús como usuarios.

### Características principales

- ✅ Sistema de autenticación con registro y login
- ✅ Gestión de sesiones y cookies ("Remember me")
- ✅ Control de acceso basado en roles (admin/usuario)
- ✅ Visualización del menú diario
- ✅ Consulta de menús completos
- ✅ Panel de administración para gestión de menús
- ✅ Panel de administración para gestión de usuarios
- ✅ Interfaz responsive con Bootstrap 5
- ✅ Navegación dinámica según rol de usuario

## 🗂️ Estructura de directorios

```
pt1-restaurant/
│
├── index.php              # Página principal/home
├── login.php              # Sistema de autenticación
├── register.php           # Registro de nuevos usuarios
├── logout.php             # Cierre de sesión
├── daymenu.php            # Visualización del menú diario
├── viewmenus.php          # Visualización de todos los menús
├── adminmenus.php         # Panel de administración de menús
├── adminusers.php         # Panel de administración de usuarios
├── tester.php             # Archivo de pruebas
│
├── fn-php/                # Funciones PHP del backend
│   ├── fn-users.php       # Funciones de gestión de usuarios
│   ├── fn-menu.php        # Funciones de gestión de menús
│   └── fn-roles.php       # Funciones de control de acceso
│
├── includes/              # Componentes reutilizables
│   ├── topmenu.php        # Barra de navegación superior
│   └── footer.php         # Pie de página
│
├── files/                 # Archivos de datos
│   ├── daymenu.txt        # Menú del día
│   ├── categories.txt     # Categorías de platos
│   └── users.txt          # Base de datos de usuarios (texto plano)
│
├── images/                # Recursos gráficos
│   ├── restaurant.jpg     # Imagen principal
│   └── ip_logo_sense_lletres.png  # Logo de ProvenSoft
│
└── css/                   # Estilos personalizados
    └── main.css           # Hoja de estilos principal
```

## 🚀 Cómo arrancar el proyecto

### Requisitos previos

- **PHP 7.4 o superior**
- **Servidor web** (Apache, Nginx, o el servidor integrado de PHP)
- Navegador web moderno

### Opción 1: Servidor integrado de PHP (recomendado para desarrollo)

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/alba-mu/pt1-restaurant.git
   cd pt1-restaurant
   ```

2. **Inicia el servidor integrado de PHP:**
   ```bash
   php -S localhost:8000
   ```

3. **Accede a la aplicación:**
   Abre tu navegador y ve a:
   ```
   http://localhost:8000
   ```

### Opción 2: Apache/Nginx

1. **Clona el repositorio** en tu directorio web (ej: `htdocs`, `www`, etc.):
   ```bash
   git clone https://github.com/alba-mu/pt1-restaurant.git
   ```

2. **Configura el servidor** para que apunte al directorio del proyecto

3. **Accede a la aplicación** desde tu navegador:
   ```
   http://localhost/pt1-restaurant
   ```

### Verificación de permisos

Asegúrate de que el directorio `files/` tiene permisos de lectura/escritura para que PHP pueda acceder a los archivos de datos:

```bash
chmod -R 755 files/
```

## 👤 Usuarios de prueba

Para probar la aplicación, puedes crear usuarios mediante el formulario de registro o verificar si existen usuarios predefinidos en `files/users.txt`.

### Roles disponibles:
- **admin**: Acceso completo (gestión de menús y usuarios)
- **user**: Acceso limitado (solo visualización de menús)

## 🔒 Funcionalidades por rol

### Usuario registrado (`user`)
- ✅ Ver página de inicio
- ✅ Consultar menú del día
- ✅ Ver todos los menús disponibles
- ❌ NO puede acceder a paneles de administración

### Administrador (`admin`)
- ✅ Todas las funcionalidades de usuario
- ✅ Gestionar menús (Admin Menus)
- ✅ Gestionar usuarios (Admin Users)

## 🛠️ Tecnologías utilizadas

- **Backend:** PHP (sesiones, cookies, autenticación)
- **Frontend:** HTML5, CSS3, Bootstrap 5.3.3
- **Almacenamiento:** Archivos de texto plano (.txt)
- **Arquitectura:** MVC simplificado con separación de funciones

## 📝 Notas importantes

⚠️ **Seguridad:** Este proyecto almacena contraseñas en texto plano en archivos `.txt`. Es ideal para fines educativos, pero **NO debe usarse en producción** sin implementar:
- Hash de contraseñas (bcrypt, Argon2)
- Base de datos real (MySQL, PostgreSQL)
- Validación y sanitización robusta
- Protección CSRF
- HTTPS

## 📄 Licencia

Proyecto educativo desarrollado por **Alba Muñoz** para el módulo DAWBI-M07-Pt11.

