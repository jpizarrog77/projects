<!DOCTYPE html>
<?php

// Muestra errores de PHP en pantalla (solo útil durante proceso de desarrollo)

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluye los archivos conexión.php para la conexión con la base de datos y las funciones de inserciondatos.php

include_once "conexion.php";
include_once "insertardatos.php";

// Función para ejecutar los scripts desde la carpeta 'scripts' y devuelve la salida sin espacios innecesarios

function run($script) {
    return trim(shell_exec("bash scripts/$script"));
}

/* --- RECOLECCIÓN DE LOS DATOS DEL SISTEMA --- */

// CPU

$cpu_raw = run("useCPU.sh");
preg_match('/(\d+\.\d+)\s+us/', $cpu_raw, $cpuMatch);
$cpu_val = $cpuMatch[1] ?? null;

// RAM y procesos activos

$ram = run("ram.sh");
$procesos = run("runProcess.sh");

// Estado del sistema

$uptime = run("timeOnline.sh");
$reboot_raw = run("lastReboot.sh");
preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2})/', $reboot_raw, $match);
$reboot = $match[1] ?? null;

// Red

$dns = run("DNSserv.sh");
$ip = run("IPserv.sh");
$ipDetail = run("IPservDetail.sh");
$so_raw = run("os.sh");
preg_match('/PRETTY_NAME="([^"]+)"/', $so_raw, $match);
$so = $match[1] ?? substr($so_raw, 0, 200);
$version = ""; // Ajustar si os.sh devuelve versión también

// Almacenamiento

$usb = run("dispUSB.sh");
$disco = run("fileSist.sh");
$kernel = run("listModules.sh");

// Interfaces de red

$interfaces = explode("\n", run("netInterfaces.sh"));

/* --- INSERCIONES DE DATOS EN LA BASE DE DATOS --- */

insertarRecursos($cpu_val, $ram, $procesos);
insertarEstadoSistema($uptime, $reboot);
insertarRed($dns, $ip, $ipDetail, $so, $version);
insertarAlmacenamiento($usb, $disco, $kernel);

foreach ($interfaces as $line) {
    if (preg_match('/^(\w+):.*(UP|DOWN)/', $line, $ifMatch)) {
        insertarInterfacesRed($ifMatch[1], $ifMatch[2], ""); // IP por interfaz no está definida
    }
}

/* --- OBTENER ÚLTIMO REGISTRO DE RECURSOS PARA MOSTRAR --- */

$res = $connection->query("SELECT * FROM recursos_sistema ORDER BY id DESC LIMIT 1");
$recurso = $res->fetch_assoc();
?>

<!-- HTML-->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">  <!-- Enlace a hoja de estilos -->
    <title>Dashboard Monitorización Servidor</title>
</head>
<body>
    <!-- Barra de navegación -->
    <nav>
        <ul>
            <li><a href="#about">About</a></li>
            <li class="desplegable">
                <a href="#dashboard">Dashboard ▼</a>
                <ul class="menu">
                    <li><a href="#almacenamiento">Almacenamiento</a></li>
                    <li><a href="#estadosistema">Estado del sistema</a></li>
                    <li><a href="#recursossistema">Recursos del sistema</a></li>
                    <li><a href="#infored">Info de red</a></li>
                 </ul>
            </li>
            <li><a href="#check">Prueba de conexión</a></li>
        </ul>
    </nav>
    <!-- Primer logo -->
    <section>
        <div class="logotitle">
            <img src="img/logo_ServVisor.png" class="imglogo">
        </div>
    </section>
    <!-- Función Dashboard -->
    <section id="about" class="about">
        <article>
            <div id="info" class="info">
                <h3>Funcionalidad y cometido</h3>
                <hr class="divider">
                <p>Panel web de administración que visualiza en tiempo real la información de monitorización del servidor. Incluye recursos, red, servicios, y almacena los datos para análisis posterior.</p>
            </div>
        </article>
    </section>
    <!-- Datos monitorización -->
    <section id="dashboard" class="dashboard">
        <article>

            <div id= "tituloDash" class="titleDash"><h2>Monitorización servidor</h2></div>

            <div id="almacenamiento" class="infoStorage">
                <h3>Datos almacenamiento</h3>
                <hr class="divider">
                <p><strong>Dispositivos USB:</strong> <pre><?= $usb ?></pre></p>
                <p><strong>Uso del disco:</strong> <pre><?= $disco ?></pre></p>
                <p><strong>Módulos del kernel:</strong> <pre><?= $kernel ?></pre></p>
            </div>

            <div id="estadosistema" class="systemState">
                <h3>Datos sistema de archivos</h3>
                <hr class="divider">
                <p><strong>Uptime:</strong> <?= $uptime ?></p>
                <p><strong>Último reinicio:</strong> <?= $reboot ?></p>
            </div>

             <div id="recursossistema" class="systemRecourses">
                <h3>Datos recursos del servidor</h3>
                <hr class="divider">
                <p><strong>Uso CPU:</strong> <?= $cpu_val ?>%</p>
                <p><strong>RAM:</strong> <pre><?= $ram ?></pre></p>
                <p><strong>Procesos:</strong> <pre><?= $procesos ?></pre></p>
             </div>

             <div id="infored" class="infoNet">
                <h3>Info red del servidor</h3>
                <hr class="divider">
                <p><strong>Dominio DNS:</strong> <?= $dns ?></p>
                <p><strong>IP del servidor:</strong> <?= $ip ?></p>
                <p><strong>Detalles de IP:</strong> <pre><?= $ipDetail ?></pre></p>
                <p><strong>Sistema operativo:</strong> <?= $so ?></p>
             </div>
        </article>
    </section>
    <!-- Prueba de conexión -->
    <section id="check" class="check">
        <article>
            <div id="tituloCheck" class="titleCheck">
                <h2>Connection Check</h2>
                <hr class="divider">
                <h3>Prueba de conexión</h3>
                <hr class="divider">
                <ul>
                    <?php 
                    /*
                    PROPÓSITO:
                    Este bloque PHP recorre un array de interfaces de red ($interfaces) y genera una lista HTML (<ul>) en la que cada elemento (<li>) representa una interfaz
                    y su estado actual (por ejemplo, "eth0: UP").
                    
                    FUNCIONAMIENTO:
                    Se utiliza un bucle foreach para iterar sobre cada línea del array $interfaces.
                    Cada línea se imprime dentro de un <li> usando <?= ... ?> (atajo para echo).
                    Se aplica la función htmlspecialchars() para evitar problemas de seguridad como XSS, convirtiendo caracteres especiales a su equivalente HTML seguro.
                    El resultado es una lista HTML visible para el usuario con las interfaces del sistema.
                    */
                    foreach ($interfaces as $line): ?>
                        <li><?= htmlspecialchars($line) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </article>
    </section> 
    <!-- Segundo logo -->
    <section>
        <div class="logotitle2">
            <img src="img/logo_ServVisor.png" class="imglogo2">
        </div>
    </section>
    <!-- Importar scripts del archivo index.js -->
    <script src="index.js"></script>
</body>
</html>
