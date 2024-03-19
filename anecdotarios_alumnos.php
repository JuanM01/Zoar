<?php
session_start();

// Verificar si el alumno ha iniciado sesión
if (!isset($_SESSION['id_alumno'])) {
    header("Location: InicioSesion.php");
    exit();
}

// Obtener el ID del alumno de la sesión
$id_alumno = $_SESSION['id_alumno'];

// Consultar la base de datos para obtener los anecdotarios asociados al alumno
include('C:\xampp\htdocs\Zoar\conexión.php');

$stmt = $conn->prepare("SELECT id_anecdotario, contenido, fecha_creacion FROM anecdotarios WHERE id_alumno = ?");
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$stmt->store_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anecdotarios del Alumno</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border-radius: 5px;
        }

        .volver{
            margin: 15px;
            width:50px;
            background-color: #3498db;
            border-radius: 50px;
        }

        .anecdotarios-list {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .anecdotarios-list ul {
            list-style: none;
            padding: 0;
        }

        .anecdotarios-list li {
            margin-bottom: 15px;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <a href="principal_alumno.php" class = "volver">Volver </a>

    <h1>Anecdotarios del Alumno</h1>

    <?php
    // Verificar si hay anecdotarios asociados al alumno
    if ($stmt->num_rows > 0) {
        // Mostrar la lista de anecdotarios en un div con estilos
        echo "<div class='anecdotarios-list'>";
        echo "<ul>";
        $stmt->bind_result($id_anecdotario, $contenido, $fecha_creacion);
        while ($stmt->fetch()) {
            echo "<li>";
            echo "<strong>ID del Anecdotario:</strong> $id_anecdotario <br>";
            echo "<strong>Contenido:</strong> $contenido <br>";
            echo "<strong>Fecha de Creación:</strong> $fecha_creacion <br>";
            echo "</li>";
        }
        echo "</ul>";
        echo "</div>";
    } else {
        // Mostrar mensaje si no hay anecdotarios asociados al alumno
        echo "<p class='no-anecdotarios'>No hay anecdotarios asociados a este alumno.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
    <!-- Agrega tu código HTML adicional según sea necesario -->
</body>
</html>
