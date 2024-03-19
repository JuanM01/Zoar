<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Alumno</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        input[type="text"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php
session_start();

// Verificar si el docente ha iniciado sesión
if (!isset($_SESSION['id_docente'], $_SESSION['nombre_docente'])) {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: InicioSesion.php");
    exit();
}
?>
<div class="container">
    <h1>Buscar Alumno</h1>
    <form method="post" action="Registro_actividades.php">
        <label for="documento">Número de Documento del Alumno:</label>
        <input type="text" id="documento" name="documento" required>
        <button type="submit" name="buscar_alumno">Buscar</button>
    </form>
</div>
</body>
</html>
