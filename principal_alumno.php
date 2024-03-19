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
        background-color: #3498db;
        color: #fff;
        padding: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 5px solid #DCF2F1
    }

    body {
        background-color: #DCF2F1;
        margin: 0; /* Elimina el margen predeterminado del body */
        padding: 0; /* Elimina el padding predeterminado del body */
        font-family: 'Roboto', sans-serif;
    }

    body {
        background-color: #DCF2F1;
        overflow: hidden;
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
        width: 180px;
        height: 90%;
        background-color: #3498db;
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
        background-color: #2980b9;
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

            // Verificar si el alumno ha iniciado sesión
            if (isset($_SESSION['id_alumno'], $_SESSION['nombre_alumno'])) {
                // Obtener la información de la sesión
                $nombreAlumno = $_SESSION['nombre_alumno'];

                // Mostrar mensaje de bienvenida en HTML
                echo "<span>Bienvenido, $nombreAlumno</span>";
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
                <li><a href="anecdotarios_alumnos.php"><i class='bx bxs-notepad'></i>Anecdotarios</a></li>
                <li><a href="verforos.php"> <i class='bx bxs-notepad'></i>Foros</a></li>
            </ul>
        </div>

        
    </div>
    <footer>
        <!-- Contenido del pie de página, si es necesario -->
    </footer>

</body>
</html>
