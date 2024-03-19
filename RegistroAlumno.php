<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "1065562454";
$dbname = "zoaradmin";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Operación: Agregar Alumno
if (isset($_POST['agregar_alumno'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $documento_identidad = $_POST['documento_identidad'];
    $tipo_documento = $_POST['tipo_documento'];
    $foto = ''; // Guardar la ruta de la foto, se actualizará más adelante

    // Obtener id_docente de la sesión (ajusta esto según cómo almacenes el id_docente en la sesión)
    if (isset($_SESSION['id_docente'])) {
        $id_docente = $_SESSION['id_docente'];
    } else {
        die("Error: No se pudo obtener el id_docente de la sesión.");
    }

    // Procesar la foto si se ha enviado
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'C:\Users\ACER\OneDrive\Escritorio\ZOAR\Fotos_Alumnos'; // Cambia esto según tu estructura
        $uploadFile = $uploadDir . basename($_FILES['foto']['name']);

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
            $foto = $uploadFile;
        } else {
            echo "Error al subir la foto.";
        }
    }

    // Utiliza una consulta preparada para prevenir la inyección de SQL
    $stmt = $conn->prepare("INSERT INTO alumnos (nombre, correo, password, direccion, telefono, fecha_nacimiento, documento_identidad, tipo_documento, foto, id_docente) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Vincula los parámetros
    $stmt->bind_param("sssssssssi", $nombre, $correo, $password, $direccion, $telefono, $fecha_nacimiento, $documento_identidad, $tipo_documento, $foto, $id_docente);

    if ($stmt->execute()) {
        echo "Alumno agregado con éxito.";
    } else {
        echo "Error al agregar el alumno: " . $stmt->error;
    }

    // Cierra la consulta preparada
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Alumnos</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <a href="principal.php" class="volver"> <i class='bx bx-reply'></i>Volver</a>

    <h1 class="titulo">Formulario de Alumnos</h1>
    <form id="alumnoForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" class="formulario-alumno">
        <div class="form-group">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="correo" class="form-label">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="direccion" class="form-label">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion">
        </div>
        <div class="form-group">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
        </div>
        <div class="form-group">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
        </div>
        <div class="form-group">
            <label for="documento_identidad" class="form-label">Documento de Identidad:</label>
            <input type="text" class="form-control" id="documento_identidad" name="documento_identidad">
        </div>
        <div class="form-group">
            <label for="tipo_documento" class="form-label">Tipo de Documento:</label>
            <input type="text" class="form-control" id="tipo_documento" name="tipo_documento">
        </div>
        <div class="form-group">
            <label for="foto" class="form-label">Foto:</label>
            <input type="file" class="form-control-file" id="foto" name="foto">
        </div>
        <button type="submit" name="agregar_alumno" class="btn btn-primary">Guardar</button>
    </form>
</body>
<style>
    body {
        background-color: rgb(253, 239, 239);
        margin: 0; /* Elimina el margen predeterminado del body */
        padding: 0; /* Elimina el padding predeterminado del body */
        font-family: 'Roboto', sans-serif;
    }

    .volver {
        position: fixed;
        top: 10px;
        right: 10px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
        background-color: #f9f9f9;
        padding: 8px 12px;
        border-radius: 25px;
        border: 1px solid #ccc;
        z-index: 999; /* Asegura que el botón esté por encima de otros elementos */
    }
    .volver i {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .titulo{
        text-align : center;
    }

    .formulario-alumno {
        width: 100%;
        max-width: 350px;
        margin: 10px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }

    .formulario-alumno label {
        display: block;
        margin-top: 10px;
        font-size: 12px;
    }

    .formulario-alumno input[type="text"],
    .formulario-alumno input[type="email"],
    .formulario-alumno input[type="password"],
    .formulario-alumno input[type="date"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        margin-top: 5px;
    }

    .formulario-alumno button[type="submit"] {
        width: 100%;
        padding: 8px;
        background-color: #FF90C2;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 15px;
    }

    .formulario-alumno button[type="submit"]:hover {
        background-color: #ED5AB3;
    }
</style>
</html>
