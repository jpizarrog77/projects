#!/bin/bash

# Leer el dominio de /etc/resolv.conf
DOMAIN=$(grep "^search" /etc/resolv.conf | awk '{print $2}')

# Verificar si se encontró el dominio
if [ -z "$DOMAIN" ]; then
    echo "No se pudo encontrar el dominio en /etc/resolv.conf."
else
    echo "El dominio del servidor es: $DOMAIN"
fi
