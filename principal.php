<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Página Principal</title>
    <style>
    /* Estilos para el header */
    header {
        background-color: #FF90C2;
        color: #fff;
        padding: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 5px solid rgb(253, 239, 239)
    }

    body {
        background-color: rgb(253, 239, 239);
        margin: 0; /* Elimina el margen predeterminado del body */
        padding: 0; /* Elimina el padding predeterminado del body */
        font-family: 'Roboto', sans-serif;
    }

    body {
        background-color: rgb(253, 239, 239);
    }

    .header-container {
        display: flex;
        align-items: center;
    }

    .header-options a {
        color: #fff;
        margin-right: 10px;
        text-decoration: none;
    }

    .header-options i {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Estilos para el contenido principal y sidebar */
    .background-container {
        position: relative;
        display: flex;
        height: 100vh;
    }

    .sidebar {
        width: 200px;
        height: 80%;
        background-color: #FF90C2;
        transition: width 0.3s ease;
        overflow-y: auto;
    }

    .menu {
        list-style: none;
        padding: 0;
    }

    .menu a {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 15px;
        color: white;
        text-decoration: none;
        border-bottom: 1px solid white; 
    }

    .menu a i {
        margin-bottom: 5px; /* Ajusta la separación entre el ícono y el texto según sea necesario */
    }
    .menu a:hover {
        background-color: #ED5AB3;
    }

    .content {
        flex-grow: 1;
        padding: 20px;
    }
</style>
</head>
<body>

    <header>
        <div>
            <?php
            session_start();

            // Verificar si el docente ha iniciado sesión
            if (isset($_SESSION['id_docente'], $_SESSION['nombre_docente'])) {
                // Obtener la información de la sesión
                $nombreDocente = $_SESSION['nombre_docente'];

                // Mostrar mensaje de bienvenida en HTML
                echo "<span>Bienvenido, $nombreDocente</span>";
            } else {
                // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
                header("Location: InicioSesion.php");
                exit();
            }
            ?>
        </div>
        <div class="header-options">
                <a href="InicioSesion.php"> <i class='bx bx-exit' ></i>Cerrar Sesión</a>
        </div>
    </header>

    <div class="background-container">
        <div class="toggle-btn" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="sidebar">
            <ul class="menu">
                <li><a href="RegistroAlumno.php"><i class='bx bxs-user-plus'></i> <br> Registrar Alumno</a></li>
                <li><a href="ConsultarAlumnos.php"><i class='bx bxs-group'></i> <br> Ver Alumnos <br> Registrados</a></li>
                <li><a href="crearforo.php"> <i class='bx bxs-notepad'></i>Foros</a></li>
            </ul>
        </div>

        
    </div>
    <footer>
        <!-- Contenido del pie de página, si es necesario -->
    </footer>

</body>
</html>
