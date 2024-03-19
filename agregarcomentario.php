<?php
session_start();
include('C:\xampp\htdocs\Zoar\conexión.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_comentario'])) {
    $id_alumno = 1; // Obtener el ID del alumno desde la sesión
    $id_foro = $_POST['id_foro'];
    $contenido = $_POST['contenido'];

    $stmt = $conn->prepare("INSERT INTO comentarios (id_foro, id_alumno, contenido, fecha_creacion) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $id_foro, $id_alumno, $contenido);

    if ($stmt->execute()) {
        header("Location: vercomentarios.php?id_foro={$id_foro}");
        exit();
    } else {
        echo "Error al agregar el comentario. Por favor, inténtalo de nuevo.";
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirigir si se intenta acceder directamente a este archivo sin enviar el formulario
    header("Location: verforos.php");
    exit();
}
?>