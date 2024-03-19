<?php
session_start();

// Verificar si el docente ha iniciado sesión
if (!isset($_SESSION['id_docente'])) {
    header("Location: InicioSesion.php");
    exit();
}

// Obtener el ID del docente de la sesión
$id_docente = $_SESSION['id_docente'];

// Verificar si se ha enviado el formulario de búsqueda
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar_alumno'])) {
    // Obtener el número de documento del alumno a buscar
    $documento = $_POST['documento'];

    // Realizar la consulta para obtener los datos del alumno
    include('conexión.php');
    $stmt = $conn->prepare("SELECT * FROM alumnos WHERE documento_identidad = ?");
    $stmt->bind_param("s", $documento);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró al alumno
    if ($result->num_rows > 0) {
        // Mostrar los datos del alumno
        $alumno = $result->fetch_assoc();

        // Consultar las especialidades del alumno
        $stmt = $conn->prepare("SELECT * FROM records WHERE id_alumno = ?");
        $stmt->bind_param("i", $alumno['id']);
        $stmt->execute();
        $especialidades_result = $stmt->get_result();

        // Almacenar las especialidades en un array
        $especialidades = [];
        while ($row = $especialidades_result->fetch_assoc()) {
            $especialidades[] = $row;
        }
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Datos del Alumno</title>
        </head>
        <body>
            <h1>Datos del Alumno</h1>
            <p><strong>Nombre:</strong> <?php echo $alumno['nombre']; ?></p>
            <p><strong>Tipo de Documento:</strong> <?php echo $alumno['tipo_documento']; ?></p>
            <p><strong>Número de Documento:</strong> <?php echo $alumno['documento_identidad']; ?></p>
            
            <!-- Mostrar las especialidades y las actividades realizadas correspondientes -->
            <h2>Especialidades</h2>
            <table>
                <tr>
                    <th>Especialidad</th>
                    <th>Realizadas</th>
                    <th>Faltantes</th>
                </tr>
                <?php foreach ($especialidades as $especialidad): ?>
                <tr>
                    <td><?php echo $especialidad['nombre']; ?></td>
                    <td><?php echo $especialidad['realizadas']; ?></td>
                    <td><?php echo $especialidad['faltantes']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            
            <!-- Formulario para ingresar las actividades realizadas -->
            <h2>Ingresar Actividades Realizadas</h2>
            <form method="post" action="procesar_realizadas.php">
                <input type="hidden" name="id_alumno" value="<?php echo $alumno['id']; ?>">
                <label for="especialidad">Especialidad:</label>
                <select id="especialidad" name="especialidad">
                    <?php foreach ($especialidades as $especialidad): ?>
                    <option value="<?php echo $especialidad['id']; ?>"><?php echo $especialidad['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="realizadas">Actividades Realizadas:</label>
                <input type="number" id="realizadas" name="realizadas" min="0">
                <button type="submit" name="registrar_realizadas">Registrar</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "No se encontró ningún alumno con ese número de documento.";
    }

    // Cerrar la conexión y liberar los recursos
    $stmt->close();
    $conn->close();
}
?>
