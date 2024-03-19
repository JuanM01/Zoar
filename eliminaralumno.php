<?php
session_start();
include('C:\xampp\htdocs\Zoar\conexión.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_alumno = $_GET['id'];

    try {
        // Iniciar una transacción
        $conn->begin_transaction();

        // Eliminar al alumno y sus anecdotarios asociados
        $stmt = $conn->prepare("DELETE FROM alumnos WHERE id = ?");
        $stmt->bind_param("i", $id_alumno);

        if ($stmt->execute()) {
            // Confirmar la transacción si la eliminación del alumno fue exitosa
            $conn->commit();

            // Redirigir a la página de consulta de alumnos después de la eliminación exitosa
            header("Location: ConsultarAlumnos.php");
            exit();
        } else {
            // Cancelar la transacción si hay un error
            $conn->rollback();

            // Manejar errores de eliminación
            echo "Error al eliminar el alumno. Por favor, inténtalo de nuevo.";
        }

        $stmt->close();
    } catch (Exception $e) {
        // Manejar excepciones
        echo "Error: " . $e->getMessage();
        $conn->rollback();
    }

    $conn->close();
} else {
    // Redirigir si se intenta acceder directamente a este archivo sin enviar el ID del alumno
    header("Location: ConsultarAlumnos.php");
    exit();
}
?>
