<?php
// Datos de conexión
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

// Operación: Agregar Administrador
if (isset($_POST['agregar_admin'])) {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $foto = $_POST['foto'];

    // Crear la consulta SQL
    $sql = "INSERT INTO administradores (nombre, correo, password, foto) VALUES ('$nombre', '$correo', '$password', '$foto')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Administrador agregado con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Administradores</title>
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <h1 class="titulo">Formulario de Administradores</h1>
    <div class="contenedor">
        <?php
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="formulario-admin">
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
                <label for="foto" class="form-label">URL de la foto:</label>
                <input type="file" class="form-control-file" id="foto" name="foto">
            </div>
            <button type="submit" name="agregar_admin" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</body>
<style>
.formulario-admin {
    width: 100%;
    max-width: 350px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
}

.formulario-admin label {
    display: block;
    margin-top: 20px;
    font-size: 14px;
}

.formulario-admin input[type="text"],
.formulario-admin input[type="email"],
.formulario-admin input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    margin-top: 5px;
}

.formulario-admin button[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #FFC0D9;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
}

.formulario-admin button[type="submit"]:hover {
    background-color: #FF90BC;
}

.error-message {
    color: red;
    margin-top: 10px;
}
</style>
</html>
