# Dockerfile para MySQL con script de inicialización incluido
FROM mysql:8

# Información del mantenedor
LABEL maintainer="ilverand"
LABEL description="MySQL 8 con base de datos users preconfigurada"

# Copiar el script de inicialización
COPY init.sql /docker-entrypoint-initdb.d/

# Exponer el puerto 3306
EXPOSE 3306
