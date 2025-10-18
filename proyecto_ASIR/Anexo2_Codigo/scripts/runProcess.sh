#!/bin/bash

# Script para mostrar los procesos en estado "running"

echo "==== PROCESOS EN ESTADO 'RUNNING' ===="
echo ""

# Mostrar procesos cuyo estado es 'R' (running) usando ps
ps -eo pid,ppid,user,stat,cmd | awk '$4 ~ /R/'
