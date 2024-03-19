<?php
include('C:\xampp\htdocs\Zoar\conexión.php');

// Verificar si se ha proporcionado un ID de alumno válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_alumno = $_GET['id'];

    // Realizar consulta para obtener los datos del alumno por su ID
    $stmt = $conn->prepare("SELECT nombre, correo, telefono, tipo_documento, documento_identidad FROM alumnos WHERE id = ?");
    $stmt->bind_param("i", $id_alumno);
    $stmt->execute();
    $stmt->bind_result($nombre, $correo,$telefono, $tipo_documento, $documento_identidad);
    $stmt->fetch();
    $stmt->close();
} else {
    // Redirigir o mostrar un mensaje de error si no se proporciona un ID válido
    header("Location: consultaalumno.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
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

        div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #3498db;
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
    <h1>Editar Alumno</h1>
    
    <!-- Formulario de edición -->
    <form id="editarAlumnoForm" method="post" action="procesar_edicion_alumno.php">
        <input type="hidden" name="id_alumno" value="<?php echo $id_alumno; ?>">

        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
        </div>

        <div>
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?php echo $correo; ?>" required>
        </div>

        <div>
            <label for="telefono">telefono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo $telefono; ?>" required>
        </div>

        <div>
            <label for="tipo_documento">tipo_documento:</label>
            <input type="text" id="tipo_documento" name="tipo_documento" value="<?php echo $tipo_documento; ?>" required>
        </div>

        <div>
            <label for="documento_identidad">documento_identidad:</label>
            <input type="text" id="documento_identidad" name="documento_identidad" value="<?php echo $documento_identidad; ?>" required>
        </div>

        

        <!-- Agrega aquí los campos adicionales del formulario según tus necesidades -->

        <button type="submit" name="guardar_cambios">Guardar Cambios</button>
    </form>

    <!-- Agrega aquí tu código HTML adicional según sea necesario -->
</body>
</html>
