#!/bin/bash

# Script para verificar el estado de Docker y desplegar la aplicación

echo "🔍 Verificando estado de Docker..."
echo ""

# Verificar si la imagen existe
if docker images | grep -q "ilverand/php-app"; then
    echo "✅ Imagen 'ilverand/php-app:1.0' construida exitosamente"
    echo ""
    
    # Preguntar si quiere hacer push a Docker Hub
    echo "📤 ¿Deseas subir la imagen a Docker Hub ahora?"
    echo "   1) Sí, hacer login y push"
    echo "   2) No, solo iniciar la aplicación localmente"
    echo "   3) Cancelar"
    read -p "Elige una opción (1-3): " option
    
    case $option in
        1)
            echo ""
            echo "🔐 Iniciando sesión en Docker Hub..."
            docker login
            
            if [ $? -eq 0 ]; then
                echo ""
                echo "📤 Subiendo imagen a Docker Hub..."
                docker push ilverand/php-app:1.0
                
                if [ $? -eq 0 ]; then
                    echo ""
                    echo "✅ Imagen subida exitosamente a Docker Hub!"
                    echo "   Verifica en: https://hub.docker.com/r/ilverand/php-app"
                fi
            fi
            ;;
        2)
            echo ""
            echo "⏭️  Saltando push a Docker Hub..."
            ;;
        3)
            echo ""
            echo "❌ Operación cancelada"
            exit 0
            ;;
    esac
    
    echo ""
    echo "🚀 Iniciando aplicación con Docker Compose..."
    docker-compose up -d
    
    if [ $? -eq 0 ]; then
        echo ""
        echo "✅ Aplicación iniciada exitosamente!"
        echo ""
        echo "📊 Estado de los contenedores:"
        docker-compose ps
        echo ""
        echo "🌐 Accede a la aplicación en: http://localhost:8080"
        echo ""
        echo "📝 Comandos útiles:"
        echo "   - Ver logs: docker-compose logs -f"
        echo "   - Detener: docker-compose down"
        echo "   - Reiniciar: docker-compose restart"
    fi
    
else
    echo "⏳ La imagen aún se está construyendo..."
    echo ""
    echo "   Para ver el progreso, ejecuta:"
    echo "   docker ps -a"
    echo ""
    echo "   O verifica las imágenes disponibles:"
    echo "   docker images"
    echo ""
    echo "   Vuelve a ejecutar este script cuando termine el build."
fi
