<?php

/*
 Función: insertarRecursos
 Propósito: Inserta información sobre el uso de CPU, RAM y procesos activos en la tabla `recursos_sistema`.
*/

function insertarRecursos($cpu, $ram, $procesos) {  // Declara una función llamada insertarRecursos que recibe tres parámetros: uso de CPU, memoria RAM y número de procesos
    global $connection;  // Usa la variable global $connection para acceder a la conexión con la base de datos dentro de la función
    $sql = "INSERT INTO recursos_sistema (cpu_uso, ram_total, procesos_activos) VALUES (?, ?, ?)";   // Define una consulta SQL para insertar datos en la tabla 'recursos_sistema' usando marcadores (placeholders) para los valores
    $stmt = $connection->prepare($sql);  // Prepara la consulta SQL usando la conexión activa para evitar inyecciones SQL y permitir el enlace de parámetros
    $stmt->bind_param("sss", $cpu, $ram, $procesos);  // Enlaza los valores de las variables a los marcadores de la consulta. "sss" indica que los tres valores son cadenas (strings)
    $stmt->execute();  // Ejecuta la consulta con los valores proporcionados, insertando los datos en la base de datos
    $stmt->close();  // Cierra el objeto de la sentencia preparada para liberar recursos
}

/*
 Función: insertarEstadoSistema
 Propósito: Guarda el tiempo de actividad y la fecha del último reinicio en la tabla `estado_sistema`.
*/

function insertarEstadoSistema($uptime, $reboot) {
/*
Declara una función llamada insertarEstadoSistema que recibe dos parámetros:
$uptime = tiempo que el sistema ha estado activo
$reboot = fecha y hora del último reinicio del sistema
*/
    global $connection;  global $connection;   // Accede a la variable global $connection para usar la conexión activa con la base de datos
    $sql = "INSERT INTO estado_sistema (tiempo_actividad, ultimo_reinicio) VALUES (?, ?)"; // Define una consulta SQL para insertar los valores en la tabla 'estado_sistema', usando placeholders (?) para los datos dinámicos
    $stmt = $connection->prepare($sql);  // Prepara la consulta para su ejecución, protegiendo contra inyecciones SQL
    $stmt->bind_param("ss", $uptime, $reboot);  // Enlaza los parámetros a los placeholders de la consulta:, "ss" indica que ambos valores son strings (cadenas de texto)
    $stmt->execute();  // Ejecuta la consulta preparada con los valores proporcionados
    $stmt->close();  // Cierra la sentencia preparada para liberar recursos del sistema
}

/*
 Función: insertarRed
 Propósito: Inserta información de red del servidor en la tabla `red_servidor`, incluyendo DNS, IP y sistema operativo.
*/

function insertarRed($dns, $ip, $ipDetail, $so, $version) {
/* 
Declara la función insertarRed que recibe cinco parámetros:
$dns = nombre de dominio o servidor DNS configurado
$ip = dirección IP principal del servidor
$ipDetail = detalles adicionales de configuración de red o interfaces
$so = nombre del sistema operativo detectado
$version = versión del sistema operativo
*/
    global $connection;   // Utiliza la variable global $connection para acceder a la base de datos
    $sql = "INSERT INTO red_servidor (dns_dominio, ip_servidor, ip_detail_servidor, sist_operativo, version_so) VALUES (?, ?, ?, ?, ?)"; // Define una consulta SQL que insertará los cinco valores en la tabla 'red_servidor'. Los signos de interrogación (?) son placeholders que se reemplazarán por los valores reales
    $stmt = $connection->prepare($sql);   // Prepara la consulta para su ejecución, asegurando que los datos se manejen de forma segura (evita inyección SQL)
    $stmt->bind_param("sssss", $dns, $ip, $ipDetail, $so, $version);  // Asocia las variables a los placeholders de la consulta, "sssss" indica que los cinco parámetros son de tipo string (texto)
    $stmt->execute();   // Ejecuta la consulta, insertando los datos en la tabla correspondiente
    $stmt->close();  $stmt->close();  // Cierra la sentencia preparada para liberar recursos del sistema
}

/*
 Función: insertarAlmacenamiento
 Propósito: Registra información sobre dispositivos USB conectados, uso de disco y módulos del kernel en `almacenamiento`.
*/

function insertarAlmacenamiento($usb, $disco, $kernel) {
/*
Declara la función insertarAlmacenamiento que recibe tres parámetros:
$usb = información sobre los dispositivos USB conectados
$disco = estado o uso del sistema de archivos/disco
$kernel = lista de módulos del kernel cargados
*/
    global $connection;  // Utiliza la variable global $connection para acceder a la base de datos
    $sql = "INSERT INTO almacenamiento (dispositivos_usb, uso_disco, modulos_kernel) VALUES (?, ?, ?)";   // Define la consulta SQL que insertará los tres valores en la tabla 'almacenamiento'. Los signos de interrogación (?) son placeholders para los datos
    $stmt = $connection->prepare($sql);   // Prepara la sentencia SQL para su ejecución segura mediante una consulta preparada
    $stmt->bind_param("sss", $usb, $disco, $kernel);  // Enlaza los tres parámetros a los placeholders de la consulta, "sss" indica que los tres valores son strings (cadenas de texto)
    $stmt->execute();   // Ejecuta la consulta, insertando los datos en la base de datos
    $stmt->close();   // Cierra la sentencia preparada para liberar recursos
}

/*
 Función: insertarInterfacesRed
 Propósito: Guarda los datos de cada interfaz de red detectada en la tabla `interfaces_red`.
            Incluye nombre de la interfaz, su estado (UP/DOWN) y la IP asignada (si se usa).
*/

function insertarInterfacesRed($interfaz, $estado, $ip) {
/*
Declara la función insertarInterfacesRed que recibe tres parámetros:
$interfaz = nombre de la interfaz de red (por ejemplo, eth0, wlan0)
$estado = estado actual de la interfaz (UP o DOWN)
$ip = dirección IP asignada a esa interfaz (si la tiene)
*/
    global $connection;   // Accede a la variable global $connection para poder usar la conexión a la base de datos
    $sql = "INSERT INTO interfaces_red (interfaz_nombre, estado, ip_asignada) VALUES (?, ?, ?)";   // Define una sentencia SQL para insertar los valores en la tabla 'interfaces_red'. Los signos de interrogación (?) son marcadores de posición para los datos dinámicos
    $stmt = $connection->prepare($sql);   // Prepara la sentencia SQL para su ejecución segura, protegiendo contra inyecciones SQL
    $stmt->bind_param("sss", $interfaz, $estado, $ip);   // Enlaza los valores reales a los marcadores de la sentencia preparada, "sss" indica que los tres valores son cadenas de texto (strings)
    $stmt->execute();  // Ejecuta la sentencia, insertando los datos de la interfaz en la base de datos
    $stmt->close();  // Cierra la sentencia preparada para liberar los recursos asociados
}
?>


