#!/bin/bash

# Mostrar todas las interfaces de red y su estado (activas o caídas)
echo "Estado de las interfaces de red en el sistema:"

# Obtener todas las interfaces de red (filtrando líneas que contienen 'state')
ip -o link show | awk -F': ' '{print $2}' | while IFS= read -r interface
do
    # Obtener el estado de la interfaz (UP, DOWN, etc.)
    state=$(ip link show "$interface" | grep -oP '(?<=state )\w+')

    # Verifica si se obtuvo el estado
    if [[ -z "$state" ]]; then
        echo "$interface: Estado desconocido"
    elif [[ "$state" == "UP" ]]; then
        echo "$interface: UP"
    else
        echo "$interface: DOWN"
    fi
done
