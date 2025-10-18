#!/bin/bash
# Muestra el uso de la CPU en tiempo real con top
top -b -n 1 | grep "Cpu(s)"
