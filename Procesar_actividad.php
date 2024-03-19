<?php
// Incluir el archivo de conexión a la base de datos y definir la función obtenerIdAlumno()
require 'conexión.php';

function obtenerIdAlumno($documento) {
    global $conn;
    
    // Preparar la consulta para obtener el ID del alumno basado en el documento de identidad
    $stmt = $conn->prepare("SELECT id FROM alumnos WHERE documento_identidad = ?");
    $stmt->bind_param("s", $documento);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verificar si se encontró el alumno
    if ($result->num_rows > 0) {
        // Obtener el ID del alumno
        $row = $result->fetch_assoc();
        $id_alumno = $row['id'];
        return $id_alumno;
    } else {
        // Si no se encontró el alumno, devolver null o algún otro indicador de error
        return null;
    }
}

// Verificar si se ha enviado el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar_registro'])) {
    // Obtener el documento de identidad del alumno del formulario
    $documento = $_POST['documento'];
    
    // Obtener el ID del alumno usando el documento de identidad
    $id_alumno = obtenerIdAlumno($documento);
    echo $id_alumno;

    if ($id_alumno !== null) {
        // Preparar la consulta SQL para insertar los datos del registro
        $stmt = $conn->prepare("INSERT INTO registros (realizadas, faltantes, id_alumno, id_especialidad) VALUES (?, ?, ?, ?)");
        
        // Iterar sobre cada especialidad para procesar sus datos
        for ($i = 1; $i <= 13; $i++) {
            // Obtener los valores de realizadas y faltantes para la especialidad actual
            $realizadasKey = "realizadas_especialidad_$i";
            $faltantesKey = "faltantes_especialidad_$i";
            
            $realizadas = isset($_POST[$realizadasKey]) ? $_POST[$realizadasKey] : 0;
            $faltantes = isset($_POST[$faltantesKey]) ? $_POST[$faltantesKey] : 0;
        
            // Actualizar los datos en la base de datos
            $stmt->bind_param("iiii", $realizadas, $faltantes, $id_alumno, $i);
            $stmt->execute();
        }

        // Calcular el total de faltantes
        $total_faltantes = 0;
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'faltantes_especialidad_') === 0) {
                $total_faltantes += intval($value);
            }
        }

        // Obtener el total de actividades realizadas
        $total_realizadas = $_POST['realizadas_total'];

        // Insertar los totales en la especialidad "Total"
        $stmt->bind_param("iiii", $total_realizadas, $total_faltantes, $id_alumno, 12);
        $stmt->execute();

        // Redireccionar al usuario a verespecialidades.php después del registro exitoso
        header("Location: verespecialidades.php");
        exit(); // Asegura que el script se detenga después de redirigir
    } else {
        echo "No se encontró ningún alumno con el documento proporcionado.";
    }

    // Cerrar la conexión y liberar los recursos
    $stmt->close();
    $conn->close();
}
?>
