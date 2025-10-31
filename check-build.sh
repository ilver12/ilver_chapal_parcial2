#!/bin/bash

# Script simple para verificar el progreso del build de Docker

echo "🔍 Verificando progreso del build..."
echo ""

# Verificar si hay contenedores construyendo
if docker ps -a | grep -q "build"; then
    echo "⏳ Build en progreso..."
fi

# Verificar imágenes disponibles
echo "📦 Imágenes Docker disponibles:"
docker images | grep -E "REPOSITORY|ilverand|php"

echo ""
echo "💾 Uso de disco de Docker:"
docker system df

echo ""
echo "🔄 Para ver logs en tiempo real de un build activo, puedes buscar el proceso."
