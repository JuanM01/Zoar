<?php
session_start();

// Verificar si el docente ha iniciado sesión
if (!isset($_SESSION['id_docente'])) {
    header("Location: InicioSesion.php");
    exit();
}

// Obtener el ID del docente de la sesión
$id_docente = $_SESSION['id_docente'];

// Consultar la base de datos para obtener los alumnos registrados por el docente
include('C:\xampp\htdocs\Zoar\conexión.php');

$stmt = $conn->prepare("SELECT id, nombre, correo, tipo_documento ,documento_identidad,telefono FROM alumnos WHERE id_docente = ?");
$stmt->bind_param("i", $id_docente);
$stmt->execute();
$stmt->store_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Alumnos</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: rgb(253, 239, 239);
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .volver {
            position: fixed;
            top: 10px;
            right: 10px;
            text-decoration: none;
            color: #3498db;
            font-size: 16px;
            background-color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid #3498db;
            z-index: 999;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .alumnos-list {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 5px;
            width: 80%;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .alumnos-list ul {
            list-style: none;
            padding: 0;
        }

        .alumnos-list li {
            margin-bottom: 15px;
            border: 1px solid #ccc;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .alumnos-list i {
            font-size: 24px;
            margin-right: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-button {
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .editar-button {
            background-color: #27ae60;
        }

        .eliminar-button {
            background-color: #c0392b;
        }

        .ver-anecdotarios-button {
            background-color: #3498db;
        }

        .action-button:hover {
            filter: brightness(1.2);
        }
    </style>
</head>
<body>
    <a href="principal.php" class="volver"> <i class='bx bx-reply'></i>Volver</a>

    <h1>Alumnos Registrados</h1>

    <?php
    // Verificar si hay alumnos registrados
    if ($stmt->num_rows > 0) {
        // Mostrar la lista de alumnos en un div con estilos
        echo "<div class='alumnos-list'>";
        echo "<ul>";
        $stmt->bind_result($id_alumno, $nombre_alumno, $correo, $tipo_documento, $documento_identidad, $telefono);
        while ($stmt->fetch()) {
            echo "<li>";
            echo "<i class='bx bx-user-circle'></i> ID del alumno: $id_alumno <br>";
            echo "Nombre: $nombre_alumno <br>";
            echo "Correo: $correo <br>";
            echo "Télefono: $telefono <br>";
            echo "Tipo de documento: $tipo_documento <br>";
            echo "Número de documento: $documento_identidad <br>";

            // Botón de Editar
            echo "<a href='editaralumno.php?id=$id_alumno' class='action-button editar-button'>Editar</a>";

            // Botón de Eliminar con confirmación
            echo "<a href='eliminaralumno.php?id=$id_alumno' class='action-button eliminar-button' onclick='return confirm(\"¿Seguro(a) que desea eliminar a este alumno?\")'>Eliminar</a>";

            // Botón para ver anecdotarios
            echo "<a href='anecdotarios.php?id_alumno=$id_alumno' class='action-button ver-anecdotarios-button'>Ver Anecdotarios</a>";

            echo "</li>";
        }
        echo "</ul>";
        echo "</div>";
    } else {
        // Mostrar mensaje si no hay alumnos registrados
        echo "<p>Aún no hay alumnos registrados por este docente.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
    <!-- Agrega tu código HTML adicional según sea necesario -->

</body>
</html>
