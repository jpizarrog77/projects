<?php
// Este script se conecta a una base de datos MySQL usando la extensión mysqli

// Definición de las credenciales y parámetros de conexión

// ejecutar la funcion mysqli() -> conectarme a una base de datos con unos permisos determinados
// servidor al que me conecto -> localhost
// usuario (root) pass () database (monitoring_server)


const username = "root";    // Nombre de usuario para acceder a la base de datos
const password = "";        // Contraseña del usuario (en este caso vacía)
const database = "monitoring_server";     // Nombre de la base de datos a la que se desea conectar
const host = "localhost";                 // Servidor de base de datos (localhost al estar en el mismo servidor)

// Se crea una nueva variable de conexión MySQLi usando los parámetros definidos
$connection = new mysqli(host, username, password, database);
// Función que verifica si se ha producido un error durante la conexión
if ($connection->connect_error) {
    echo "error en conexion";   // Muestra mensaje simple si hay error 
    die("Conexión errónea: " . $connection->connect_error);  // Detalla el error y detiene la ejecución
}
?>
