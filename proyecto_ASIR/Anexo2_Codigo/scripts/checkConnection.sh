#!/bin/bash

# Script para comprobar la conexión a una IP proporcionada

read -p "Introduce la IP o dominio a comprobar: " DESTINO

echo "Comprobando conexión a $DESTINO ..."
echo ""

# Ping con 4 paquetes
ping -c 4 $DESTINO

# Verificar si fue exitoso
if [ $? -eq 0 ]; then
    echo ""
    echo "Conexión exitosa a $DESTINO"
else
    echo ""
    echo "No se pudo establecer conexión con $DESTINO"
fi
