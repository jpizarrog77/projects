#!/bin/bash

# Script para comprobar qué discos (como pendrives) están conectados y si están montados

echo "==== DISPOSITIVOS USB CONECTADOS Y SU ESTADO DE MONTAJE ===="
echo ""

# Listar dispositivos de bloque conectados (discos)
lsblk -o NAME,TRAN,SIZE,MOUNTPOINT,LABEL,MODEL | grep -E 'usb|^sd'

echo ""
echo "==== DETALLE DESDE /dev/disk/by-id/ ===="
# Mostrar enlaces simbólicos con detalles más legibles
ls -l /dev/disk/by-id | grep usb

echo ""
echo "==== MONTAJES ACTIVOS ===="
# Mostrar puntos de montaje actuales
mount | grep "^/dev"
