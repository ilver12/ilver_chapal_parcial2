# 🐳 Proyecto Docker - PHP + MySQL

Aplicación web contenerizada en PHP con base de datos MySQL para la gestión de usuarios.

## 📋 Descripción

Este proyecto consiste en una aplicación web simple desarrollada en PHP (sin framework) que se conecta a una base de datos MySQL. Permite:

- ✅ Listar usuarios (GET /users)
- ✅ Agregar nuevos usuarios (POST /users) con campos nombre y email
- ✅ Interfaz web moderna y responsive

## 🏗️ Estructura del Proyecto

```
project-root/
├── app/
│   ├── index.php          # Página principal con interfaz de usuario
│   ├── users.php          # API REST para gestión de usuarios
│   └── Dockerfile         # Dockerfile para construir la imagen PHP
├── db/
│   └── init.sql           # Script de inicialización de la BD
├── docker-compose.yml     # Configuración de servicios Docker
├── .env.example           # Ejemplo de variables de entorno
├── .gitignore            # Archivos a ignorar en Git
└── README.md             # Este archivo
```

## 🚀 Requisitos Previos

- Docker Desktop instalado ([Descargar aquí](https://www.docker.com/products/docker-desktop))
- Cuenta en Docker Hub
- Git instalado

## 🔧 Instalación y Uso

### 1. Clonar el repositorio

```bash
git clone https://github.com/ilver12/docker-php-mysql.git
cd docker-php-mysql
```

### 2. Configurar variables de entorno

```bash
cp .env.example .env
```

Edita el archivo `.env` con tus credenciales:

```env
DB_HOST=db
DB_NAME=app_db
DB_USER=appuser
DB_PASSWORD=securepassword123
DB_ROOT_PASSWORD=rootpassword123
```

### 3. Iniciar la aplicación

```bash
docker-compose up -d
```

### 4. Acceder a la aplicación

Abre tu navegador en: **http://localhost:8080**

## 🏗️ Construcción y Despliegue en Docker Hub

### Construir la imagen

```bash
cd app
docker build -t ilverand/php-app:1.0 .
```

### Autenticarse en Docker Hub

```bash
docker login
```

### Subir la imagen a Docker Hub

```bash
docker push ilverand/php-app:1.0
```

## 📦 Servicios Docker

### Servicio `app` (PHP + Apache)
- **Imagen**: `ilverand/php-app:1.0`
- **Puerto**: 8080:80
- **Extensiones PHP**: PDO, PDO_MySQL, MySQLi

### Servicio `db` (MySQL 8)
- **Imagen**: `mysql:8`
- **Puerto**: 3306:3306
- **Volumen**: `mysql_data` para persistencia
- **Script inicial**: `db/init.sql`

## 🗄️ Base de Datos

La base de datos se inicializa automáticamente con:

### Tabla `users`
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Datos de prueba
- Juan Pérez (juan.perez@example.com)
- María García (maria.garcia@example.com)
- Carlos Rodríguez (carlos.rodriguez@example.com)

## 🔄 Comandos Útiles

### Ver logs de los contenedores
```bash
docker-compose logs -f
```

### Detener los servicios
```bash
docker-compose down
```

### Detener y eliminar volúmenes (limpieza completa)
```bash
docker-compose down -v
```

### Reiniciar los servicios
```bash
docker-compose restart
```

### Ver contenedores en ejecución
```bash
docker ps
```

### Acceder al contenedor de la aplicación
```bash
docker exec -it php_app bash
```

### Acceder al contenedor de MySQL
```bash
docker exec -it mysql_db mysql -u appuser -p
```

## 🌐 API Endpoints

### GET /users.php
Lista todos los usuarios

**Respuesta:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nombre": "Juan Pérez",
      "email": "juan.perez@example.com"
    }
  ],
  "count": 1
}
```

### POST /users.php
Agrega un nuevo usuario

**Parámetros:**
- `nombre`: string (requerido)
- `email`: string (requerido, formato email válido)

**Respuesta:**
```json
{
  "success": true,
  "message": "Usuario agregado exitosamente",
  "id": 4
}
```

## 🛠️ Tecnologías Utilizadas

- **PHP 8.2** con Apache
- **MySQL 8.0**
- **Docker & Docker Compose**
- **PDO** para conexión a base de datos
- **HTML5, CSS3, JavaScript** (Vanilla)

## 📝 Notas Adicionales

- La aplicación usa PDO para interactuar con la base de datos de forma segura
- Las credenciales se gestionan mediante variables de entorno
- El volumen `mysql_data` persiste los datos incluso al reiniciar los contenedores
- La red `app_network` permite la comunicación entre servicios

## 👨‍💻 Autor

**ilverand**
- Docker Hub: [ilverand](https://hub.docker.com/u/ilverand)
- GitHub: [ilver12](https://github.com/ilver12)

## 📄 Licencia

Este proyecto fue creado con fines educativos como parte de un parcial práctico de Docker.

---

**Nota para Mac (2019):** Si usas MAMP localmente, asegúrate de detener los servicios de MAMP antes de ejecutar este proyecto para evitar conflictos de puertos.
