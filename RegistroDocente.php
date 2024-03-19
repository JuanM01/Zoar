<?php

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

// Operación: Agregar Docente
if (isset($_POST['agregar_docente'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $foto = ''; // Guardar la ruta de la foto, se actualizará más adelante

    // Procesar la foto si se ha enviado
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'C:\Users\ACER\OneDrive\Escritorio\ZOAR\Fotos_Docentes'; // Cambia esto según tu estructura
        $uploadFile = $uploadDir . basename($_FILES['foto']['name']);

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
            $foto = $uploadFile;
        } else {
            echo "Error al subir la foto.";
        }
    }

    // Utiliza una consulta preparada para prevenir la inyección de SQL
    $stmt = $conn->prepare("INSERT INTO docentes (nombre, correo, password, direccion, telefono, foto) VALUES (?, ?, ?, ?, ?, ?)");

    // Vincula los parámetros
    $stmt->bind_param("ssssss", $nombre, $correo, $password, $direccion, $telefono, $foto);

    if ($stmt->execute()) {
        echo "Docente agregado con éxito.";
    } else {
        echo "Error al agregar el docente: " . $stmt->error;
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
    <title>Formulario de Docentes</title>
    <link rel="stylesheet" href="global.css">
</head>
<body>

    <h1>Formulario de Docentes</h1>

    <form id="docenteForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
        <br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion">
        <br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono">
        <br>

        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto">
        <br>

        <button type="submit" name="agregar_docente">Guardar</button>
    </form>

</body>
<style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        input[type="file"] {
            background: none;
            margin-bottom: 15px;
        }

        button[type="submit"] {
            background-color: #FFC0D9;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #FF90BC;
        }
    </style>
</html>
