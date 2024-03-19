<?php
session_start(); // Asegúrate de iniciar la sesión si aún no está iniciada

include('C:\xampp\htdocs\Zoar\conexión.php'); // Ajusta la ruta según tu estructura de archivos

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar_cambios'])) {
    $id_alumno = $_POST['id_alumno'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $tipo_documento = $_POST['tipo_documento'];
    $documento_identidad = $_POST['documento_identidad'];

    // Puedes agregar más campos aquí según sea necesario

    // Actualizar los datos del alumno en la base de datos
    $stmt = $conn->prepare("UPDATE alumnos SET nombre = ?, correo = ?, telefono  = ?, tipo_documento  = ?, documento_identidad  = ? WHERE id = ?");
    $stmt->bind_param("ssisss", $nombre, $correo, $telefono, $tipo_documento, $documento_identidad, $id_alumno);
    
    if ($stmt->execute()) {
        // Redirigir a la página de consulta de alumnos después de la actualización exitosa
        header("Location: ConsultarAlumnos.php");
        exit();
    } else {
        // Manejar errores de actualización
        echo "Error al actualizar los datos del alumno. Por favor, inténtalo de nuevo.";
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirigir si se intenta acceder directamente a este archivo sin enviar el formulario
    header("Location: consultaalumno.php");
    exit();
}
?>
