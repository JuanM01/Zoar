<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Anecdotario</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: rgb(253, 239, 239);
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            color: #333;
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

        textarea {
            width: 100%;
            padding: 8px;
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

        .back-button {
            background-color: #FF90C2;
            color: #fff;
            padding: 10px 15px;
            margin:15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            position:absolute;
            top: 0;
        }

        .back-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h1>Agregar Anecdotario</h1>

    <?php
    session_start();

    // Verificar si el docente ha iniciado sesión
    if (!isset($_SESSION['id_docente'])) {
        header("Location: InicioSesion.php");
        exit();
    }

    // Obtener el ID del alumno desde la URL
    $id_alumno = isset($_GET['id_alumno']) ? $_GET['id_alumno'] : null;

    // Validar que se haya proporcionado el ID del alumno
    if (!$id_alumno) {
        echo "ID de alumno no proporcionado.";
        exit();
    }
    ?>

    <form method="post" action="procesar_anecdotario.php">
        <input type="hidden" name="id_alumno" value="<?php echo $id_alumno; ?>">

        <label for="contenido">Contenido:</label>
        <textarea name="contenido" required></textarea>

        <button type="submit" name="agregar_anecdotario">Agregar Anecdotario</button>
    </form>
    <a href="ConsultarAlumnos.php" class="back-button">Volver</a>
</body>
</html>
