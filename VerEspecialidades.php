<?php
    // Obtener el ID del alumno de la URL
    if(isset($_GET['id_alumno'])) {
        $id_alumno = $_GET['id_alumno'];
    } else {
        echo "Error: No se proporcionó un ID de alumno.";
        exit();
    }

    // Ejecutar consulta SQL para obtener los datos del alumno y sus especialidades
    include('conexión.php');
    $query = "SELECT 
                a.nombre AS nombre_alumno,
                a.tipo_documento,
                a.documento_identidad,
                e.nombre AS nombre_especialidad,
                r.realizadas,
                r.faltantes
            FROM 
                alumnos a
            INNER JOIN 
                registros r ON a.id = r.id_alumno
            INNER JOIN 
                especialidades e ON r.id_especialidad = e.id_especialidad
            WHERE 
                a.id = $id_alumno";

    $result = $conn->query($query);

    // Verificar si se encontraron registros
    if ($result->num_rows > 0) {
        // Obtener los datos del alumno
        $row_alumno = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Detalles del Alumno</title>
        </head>
        <body>
            <h1>Detalles del Alumno</h1>
            <p><strong>Nombre:</strong> <?php echo $row_alumno['nombre_alumno']; ?></p>
            <p><strong>Tipo de Documento:</strong> <?php echo $row_alumno['tipo_documento']; ?></p>
            <p><strong>Número de Documento:</strong> <?php echo $row_alumno['documento_identidad']; ?></p>
            
            <h2>Especialidades y Registros</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Nombre Especialidad</th>
                        <th>Realizadas</th>
                        <th>Faltantes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Almacenar los registros del alumno en un array
                    $registros_alumno = array();
                    while ($row = $result->fetch_assoc()) {
                        $registros_alumno[] = $row;
                    }

                    // Iterar sobre los registros almacenados para mostrar las especialidades y registros
                    foreach ($registros_alumno as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['nombre_especialidad']; ?></td>
                            <td><?php echo $row['realizadas']; ?></td>
                            <td><?php echo $row['faltantes']; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </body>
        </html>
        <?php
    } else {
        echo "No se encontraron registros para el alumno especificado.";
    }

    // Cerrar la conexión
    $conn->close();

?>
