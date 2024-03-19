<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Foro</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: rgb(253, 239, 239);
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .foro-detalle {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            color: #666;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #FF90C2;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include('C:\xampp\htdocs\Zoar\conexión.php');

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_foro'])) {
        $id_foro = $_GET['id_foro'];

        // Obtener información del foro
        $stmt_foro = $conn->prepare("SELECT * FROM foros WHERE id_foro = ?");
        $stmt_foro->bind_param("i", $id_foro);
        $stmt_foro->execute();
        $result_foro = $stmt_foro->get_result();
        $foro = $result_foro->fetch_assoc();
        $stmt_foro->close();

        if ($foro) {
            // Obtener comentarios del foro
            $stmt_comentarios = $conn->prepare("SELECT * FROM comentarios WHERE id_foro = ?");
            $stmt_comentarios->bind_param("i", $id_foro);
            $stmt_comentarios->execute();
            $result_comentarios = $stmt_comentarios->get_result();
            $stmt_comentarios->close();

            // Mostrar información del foro y comentarios
            echo "<div class='foro-detalle'>";
            echo "<h2>{$foro['titulo']}</h2>";
            echo "<p>{$foro['contenido']}</p>";

            if ($result_comentarios->num_rows > 0) {
                // Mostrar comentarios
                echo "<ul>";
                while ($comentario = $result_comentarios->fetch_assoc()) {
                    echo "<li>{$comentario['contenido']} - {$comentario['fecha_creacion']}</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No hay comentarios en este foro.</p>";
            }

            // Formulario para agregar comentario
            echo "<form method='post' action='agregarcomentario.php'>";
            echo "<input type='hidden' name='id_foro' value='{$id_foro}'>";
            echo "<textarea name='contenido' required></textarea>";
            echo "<button type='submit' name='agregar_comentario'>Agregar Comentario</button>";
            echo "</form>";
            echo "</div>";
        } else {
            echo "<p>Foro no encontrado.</p>";
        }
    } else {
        echo "<p>ID de foro no proporcionado.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
