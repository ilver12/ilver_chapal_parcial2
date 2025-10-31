# 📋 Instrucciones de Despliegue

## 🐳 Comandos para Docker Hub

### Paso 1: Construir la imagen Docker

```bash
cd app
docker build -t ilverand/php-app:1.0 .
```

### Paso 2: Iniciar sesión en Docker Hub

```bash
docker login
```

> Te pedirá tu usuario (ilverand) y contraseña de Docker Hub

### Paso 3: Subir la imagen a Docker Hub

```bash
docker push ilverand/php-app:1.0
```

### Paso 4: Verificar que la imagen está en Docker Hub

Visita: https://hub.docker.com/r/ilverand/php-app/tags

---

## 🚀 Ejecutar el proyecto con Docker Compose

### Volver al directorio raíz del proyecto

```bash
cd ..
```

### Iniciar los servicios

```bash
docker-compose up -d
```

### Ver los logs

```bash
docker-compose logs -f
```

### Verificar que los contenedores están corriendo

```bash
docker ps
```

### Acceder a la aplicación

Abre tu navegador en: **http://localhost:8080**

---

## 🐙 Comandos para GitHub

### Paso 1: Inicializar repositorio Git (si no está inicializado)

```bash
git init
```

### Paso 2: Agregar todos los archivos

```bash
git add .
```

### Paso 3: Hacer el commit inicial

```bash
git commit -m "Initial commit: Proyecto Docker PHP + MySQL"
```

### Paso 4: Crear repositorio en GitHub

Ve a https://github.com/new y crea un repositorio llamado **docker-php-mysql**

### Paso 5: Conectar con el repositorio remoto

```bash
git remote add origin https://github.com/ilver12/docker-php-mysql.git
```

### Paso 6: Subir el código a GitHub

```bash
git branch -M main
git push -u origin main
```

---

## 🧪 Probar la aplicación

### Listar usuarios (GET)

```bash
curl http://localhost:8080/users.php
```

### Agregar un usuario (POST)

```bash
curl -X POST http://localhost:8080/users.php \
  -d "nombre=Pedro Lopez" \
  -d "email=pedro.lopez@example.com"
```

---

## 🛑 Detener y limpiar

### Detener los servicios

```bash
docker-compose down
```

### Detener y eliminar volúmenes (limpieza completa)

```bash
docker-compose down -v
```

---

## ⚠️ Notas Importantes para Mac (2019)

1. **Si usas MAMP**, detén los servicios antes de ejecutar este proyecto:
   - MAMP usa los puertos 80/8888 y 3306 que pueden entrar en conflicto

2. **Docker Desktop debe estar corriendo**:
   - Abre Docker Desktop antes de ejecutar comandos docker

3. **Permisos**:
   - Si tienes problemas de permisos, puedes necesitar usar `sudo` en algunos comandos

---

## 📊 Verificación del Proyecto

✅ Checklist antes de entregar:

- [ ] Imagen construida: `docker images | grep ilverand/php-app`
- [ ] Imagen subida a Docker Hub: https://hub.docker.com/r/ilverand/php-app
- [ ] Aplicación corriendo: http://localhost:8080
- [ ] Base de datos funcional: Verificar que se listan los 3 usuarios de prueba
- [ ] Agregar usuario funciona: Probar formulario
- [ ] Código en GitHub: https://github.com/ilver12/docker-php-mysql
- [ ] README.md completo y detallado
- [ ] .gitignore incluido (no subir .env)
- [ ] docker-compose.yml usa la imagen de Docker Hub

---

## 🆘 Solución de Problemas

### Error: "port is already allocated"

```bash
# Verificar qué está usando el puerto
lsof -i :8080
lsof -i :3306

# Si es MAMP, detén los servicios desde la aplicación MAMP
```

### Error: "Cannot connect to the Docker daemon"

```bash
# Abre Docker Desktop y espera a que inicie completamente
```

### Error: "Access denied for user"

```bash
# Verifica que el archivo .env existe y tiene las credenciales correctas
cat .env

# Si es necesario, reconstruye todo:
docker-compose down -v
docker-compose up -d
```

### La base de datos no tiene los usuarios de prueba

```bash
# Elimina el volumen y vuelve a crear:
docker-compose down -v
docker-compose up -d
```

---

## 📞 Información Adicional

- **Usuario Docker Hub**: ilverand
- **Usuario GitHub**: ilver12
- **Imagen Docker**: ilverand/php-app:1.0
- **Puerto de aplicación**: 8080
- **Puerto de MySQL**: 3306
