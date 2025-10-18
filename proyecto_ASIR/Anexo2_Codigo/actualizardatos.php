<?php
// Incluye el archivo que contiene los datos de conexión a la base de datos
include_once "conexion.php";
// Incluye el archivo que contiene funciones para insertar datos en la base de datos
include_once "insertardatos.php";

// Función que ejecuta un script bash desde la carpeta "scripts"
function run($script) {
    $ruta = __DIR__ . "/scripts/$script";   // Forma la ruta absoluta del script
    return trim(shell_exec("bash $ruta"));  // Ejecuta el script en bash y elimina espacios innecesarios al principio y final del resultado
}

// Recolección de datos del sistema

$cpu = run("useCPU.sh");  // Ejecuta el script que devuelve el uso de CPU y almacena la información en la variable cpu
preg_match('/(\d+\.\d+)\s+us/', $cpu, $cpuMatch);   // Extrae el valor de CPU en uso (porcentaje "user space") mediante expresión regular
$cpu_val = $cpuMatch[1] ?? null;    // Guarda el valor numérico o null si no se encontró en esa variable

$ram = run("ram.sh");  // Ejecuta el script que devuelve el uso de RAM y almacena la información en la variable ram
$procesos = run("runProcess.sh");  // Ejecuta el script que enumera los procesos activos y almacena la información en la variable procesos

$uptime = run("timeOnline.sh");  // Ejecuta el script que muestra el tiempo que el sistema lleva activo y almacena la información en la variable uptime
$reboot_raw = run("lastReboot.sh");  // Ejecuta el script que devuelve la última fecha de reinicio y almacena la información en la variable reboot_raw
preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2})/', $reboot_raw, $match); // Extrae la fecha del último reinicio en formato "YYYY-MM-DD HH:MM"
$reboot = $match[1] ?? null; // Guarda el valor extraído o null si no se encontró en la variable reboot


$dns = run("DNSserv.sh");  // Ejecuta el script que obtiene información del servidor DNS y almacena la información en la variable dns
$ip = run("IPserv.sh");   // Ejecuta el script que devuelve la IP principal del servidor y almacena la información en la variable ip
$ipDetail = run("IPservDetail.sh");  // Ejecuta un script que devuelve información detallada sobre las interfaces de red e IPs y almacena la información en la variable ipDetail
$so_raw = run("os.sh");  // Ejecuta el script que devuelve datos del sistema operativo y almacena la información en la variable so_raw
preg_match('/PRETTY_NAME="([^"]+)"/', $so_raw, $match);  // Extrae un nombre amigable del SO desde /etc/os-release
$so = $match[1] ?? substr($so_raw, 0, 200);  // Usa el nombre amigable o un substring de 200 caracteres si no se encuentra

$usb = run("dispUSB.sh");  // Ejecuta el script que enumera los dispositivos USB conectados y almacena la información en la variable usb
$disco = run("fileSist.sh");  // Ejecuta el script que muestra información sobre el sistema de archivos/discos y almacena la información en la variable disco
$kernel = run("listModules.sh");  // Ejecuta un script que lista los módulos del kernel activos y almacena la información en la variable kernel

// Obtiene una lista de interfaces de red desde el script netInterfaces.sh
$interfaces = explode("\n", run("netInterfaces.sh"));  // Divide la salida del script en líneas individuales // explode("\n", ...): convierte ese texto en un array, donde cada elemento es una línea individual
// Busca el nombre de la interfaz y su estado (UP o DOWN)
foreach ($interfaces as $line) {  // Recorre cada línea de la salida anterior
    if (preg_match('/^(\w+):.*(UP|DOWN)/', $line, $ifMatch)) {   // preg_match(...) es una función que busca coincidencias en texto usando expresiones regulares.

    /* 
    En este caso, busca:
    ^(\w+): el nombre de la interfaz, al inicio de la línea (por ejemplo, eth0).
    :: seguido de dos puntos.
    .*: cualquier cosa en medio (espacios, texto, etc.).
    (UP|DOWN): finalmente, el estado de la interfaz, que puede ser UP o DOWN.
    Si se encuentra una coincidencia, los valores capturados se guardan en $ifMatch 
    */
        // Guarda el nombre de la interfaz en iface y su estado en estado
        $iface = $ifMatch[1]; // Nombre de la interfaz
        $estado = $ifMatch[2]; // Estado actual (UP o DOWN)
        $ip_if = ""; // Variable para una posible IP por interfaz (aún no implementado)
        insertarInterfacesRed($iface, $estado, $ip_if);  // Inserta los datos en la base de datos empleando esa función almacenada en insertardatos.php
    }
}

// Insertar los datos recabados en la base de datos empleando las funciones almacenadas en el archivo insertardatos.php

insertarRecursos($cpu_val, $ram, $procesos);  // Inserta uso de CPU, RAM y cantidad de procesos
insertarEstadoSistema($uptime, $reboot);      // Inserta información sobre tiempo activo y último reinicio
insertarRed($dns, $ip, $ipDetail, $so, $version);  // Inserta datos de red, sistema operativo e IPs
insertarAlmacenamiento($usb, $disco, $kernel);    // Inserta información de almacenamiento y módulos del kernel
?>

