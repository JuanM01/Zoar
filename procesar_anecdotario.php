<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Agregar Anecdotario</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .result-container {
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .back-button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="result-container">
    <?php
    session_start();
    include('C:\xampp\htdocs\Zoar\conexión.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_anecdotario'])) {
        $id_alumno = isset($_POST['id_alumno']) ? $_POST['id_alumno'] : null;
        $contenido = isset($_POST['contenido']) ? $_POST['contenido'] : null;

        // Obtener el ID del docente desde la sesión
        $id_docente = isset($_SESSION['id_docente']) ? $_SESSION['id_docente'] : null;

        // Validar que se hayan proporcionado todos los datos necesarios
        if ($id_alumno && $id_docente && $contenido) {
            $stmt_anecdotario = $conn->prepare("INSERT INTO anecdotarios (id_alumno, id_docente, contenido, fecha_creacion) VALUES (?, ?, ?, NOW())");
            $stmt_anecdotario->bind_param("iis", $id_alumno, $id_docente, $contenido);

            if ($stmt_anecdotario->execute()) {
                echo "Anecdotario agregado con éxito.";
            } else {
                echo "Error al agregar el anecdotario. Por favor, inténtalo de nuevo.";
            }

            $stmt_anecdotario->close();
        } else {
            echo "Faltan datos para agregar el anecdotario.";
        }
    }

    $conn->close();
    ?>
    <a href="#" class="back-button" onclick="history.go(-1)">Volver</a>
</div>

</body>
</html>