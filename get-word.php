<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ahorcado";
$port= 3310;

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener una palabra aleatoria
$sql = "SELECT palabra FROM palabras ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Devuelve la palabra como JSON
    $row = $result->fetch_assoc();
    echo json_encode(['palabra' => $row['palabra']]);
} else {
    echo json_encode(['error' => 'No se encontraron palabras']);
}

// Cerrar la conexión
$conn->close();
?>
