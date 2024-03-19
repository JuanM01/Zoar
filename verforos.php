<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Foros</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: rgb(253, 239, 239);
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .foro {
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

        a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            background-color: #FF90C2;
            color: #fff;
            padding: 8px 12px;
            border-radius: 5px;
            text-align: center;
        }

        a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include('C:\xampp\htdocs\Zoar\conexión.php');

    // Obtener foros existentes
    $result = $conn->query("SELECT * FROM foros");

    if ($result->num_rows > 0) {
        // Mostrar la lista de foros
        while ($row = $result->fetch_assoc()) {
            echo "<div class='foro'>";
            echo "<h2>{$row['titulo']}</h2>";
            echo "<p>{$row['contenido']}</p>";
            echo "<a href='vercomentarios.php?id_foro={$row['id_foro']}'>Ver Comentarios</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay foros activos.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
