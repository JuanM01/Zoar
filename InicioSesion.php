<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('C:\xampp\htdocs\Zoar\conexión.php');

    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Consulta preparada para obtener información del docente
    $stmt_docente = $conn->prepare("SELECT id, nombre, password FROM docentes WHERE correo = ?");
    $stmt_docente->bind_param("s", $correo);
    $stmt_docente->execute();
    $stmt_docente->store_result();

    // Consulta preparada para obtener información del alumno
    $stmt_alumno = $conn->prepare("SELECT id, nombre, password FROM alumnos WHERE correo = ?");
    $stmt_alumno->bind_param("s", $correo);
    $stmt_alumno->execute();
    $stmt_alumno->store_result();

    if ($stmt_docente->num_rows > 0) {
        $stmt_docente->bind_result($id, $nombre, $hashed_password);
        $stmt_docente->fetch();

        if (password_verify($password, $hashed_password)) {
            // Autenticación exitosa para docente
            $_SESSION['id_docente'] = $id;
            $_SESSION['nombre_docente'] = $nombre;
            $_SESSION['rol'] = 'docente';
            header('Location: principal.php');
            exit();
        }
    } elseif ($stmt_alumno->num_rows > 0) {
        $stmt_alumno->bind_result($id, $nombre, $hashed_password);
        $stmt_alumno->fetch();

        if (password_verify($password, $hashed_password)) {
            // Autenticación exitosa para alumno
            $_SESSION['id_alumno'] = $id;
            $_SESSION['nombre_alumno'] = $nombre;
            $_SESSION['rol'] = 'alumno';
            header('Location: principal_alumno.php');
            exit();
        }
    }

    // Credenciales incorrectas
    $error_message = "Credenciales incorrectas. Inténtalo de nuevo.";

    $stmt_docente->close();
    $stmt_alumno->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <h1 class="titulo">Iniciar Sesión</h1>
    <div class="contenedor">
        <?php
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>
            <br>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <br>

            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
<style>
    body {
    font-family: Arial, sans-serif;
    }

    .titulo {
        text-align: center;
        margin-top: 50px;
    }

    .contenedor {
        width: 300px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }

    .contenedor label {
        display: block;
        margin-top: 20px;
        font-size: 14px;
    }

    .contenedor input[type="email"],
    .contenedor input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        margin-top: 5px;
    }

    .contenedor button[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #FFC0D9;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
    }

    .contenedor button[type="submit"]:hover {
        background-color: #FF90BC;
    }

    .error-message {
        color: red;
        margin-top: 10px;
    }
</style>
</html>
