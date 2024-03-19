<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Foro</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: rgb(253, 239, 239);
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        form {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input,
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
            padding: 10px 15px;
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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear_foro'])) {
        $id_docente = $_SESSION['id_docente']; // Obtener el ID del docente desde la sesión
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];

        $stmt = $conn->prepare("INSERT INTO foros (id_docente, titulo, contenido, fecha_creacion) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $id_docente, $titulo, $contenido);

        if ($stmt->execute()) {
            header("Location: verforos.php");
            exit();
        } else {
            echo "Error al crear el foro. Por favor, inténtalo de nuevo.";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
    <!-- Formulario para crear un nuevo foro -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="titulo">Título del Foro:</label>
        <input type="text" name="titulo" required>
        <label for="contenido">Contenido del Foro:</label>
        <textarea name="contenido" required></textarea>
        <button type="submit" name="crear_foro">Crear Foro</button>
    </form>
</body>
</html>
