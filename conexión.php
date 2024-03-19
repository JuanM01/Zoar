<?php
$servername = "localhost";
$username = "root";
$password = "1065562454";
$dbname = "zoaradmin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta de prueba
$sql = "SELECT '' AS mensaje";

$result = $conn->query($sql);

if ($result === false) {
    // Mostrar mensajes de error si la consulta falla
    echo "Error en la consulta: " . $conn->error;
} else {
    // Si la consulta es exitosa, mostrar los resultados
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row["mensaje"];
    } else {
        echo "No se encontraron resultados.";
    }
}

?>
