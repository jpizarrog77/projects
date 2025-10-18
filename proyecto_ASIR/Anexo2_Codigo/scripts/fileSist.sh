#!/bin/bash

# Mostrar el porcentaje de uso del sistema de archivos
echo "Uso del sistema de archivos (porcentaje de uso):"

# Comando df para mostrar el uso de los sistemas de archivos en porcentaje
df -h --total | grep -E '^/dev' | awk '{print $1 ": " $5 " de uso"}'
