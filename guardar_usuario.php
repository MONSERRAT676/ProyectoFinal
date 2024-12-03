<?php
// Configuración de la base de datos
$servidor = "localhost"; // Cambia según tu configuración de servidor
$usuario = "root"; // Usuario por defecto de phpMyAdmin
$password = ""; // Si tienes contraseña, colócala aquí
$baseDatos = "ahorcado_db"; // Nombre de la base de datos

// Conectar a la base de datos
$conexion = new mysqli($servidor, $usuario, $password, $baseDatos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Verificar si se ha enviado el nombre del usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre_usuario'])) {
    $nombre_usuario = $_POST['nombre_usuario'];

    // Inicializar los intentos a 6
    $intentos_iniciales = 6;

    // Preparar la consulta para insertar el nombre de usuario y los intentos
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, intentos_restantes) VALUES (?, ?)");
    $stmt->bind_param("si", $nombre_usuario, $intentos_iniciales);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Obtener el ID del usuario recién insertado
        $usuario_id = $stmt->insert_id;

        // Redirigir al juego con el ID del usuario
        header("Location: ahorcado.html?id_usuario=$usuario_id");
        exit();
    } else {
        echo "<p>Error al guardar el usuario. Inténtalo nuevamente.</p>";
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión
$conexion->close();
?>
