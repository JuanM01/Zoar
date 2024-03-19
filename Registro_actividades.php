<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Actividades</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
<?php

    $campos = array(
        'general_mayores',
        'general_menores',
        'urologia',
        'ginecologia',
        'neurocirugia',
        'ortopedia',
        'otorrinolaringologia',
        'pediatria',
        'cardiovascular',
        'plastica',
        'maxilofacial',
        'laparoscopicas'
    );
    // Incluir el archivo de conexión
    require 'conexión.php';

    // Función para calcular el total de actividades realizadas
    function calcularTotal() {
        global $campos; // Acceder a la variable $campos definida fuera de la función
        $realizadasTotal = 0;

        // Sumar los valores de las actividades realizadas de todas las especialidades
        foreach ($campos as $campo) {
            $realizadasTotal += isset($_POST['realizadas_' . $campo]) ? intval($_POST['realizadas_' . $campo]) : 0;
        }

        return $realizadasTotal;
    }

    // Verificar si se ha enviado el formulario de búsqueda y si se ha especificado un documento
    if (isset($_POST['buscar_alumno']) && !empty($_POST['documento'])) {
        // Limpiar y escapar el documento proporcionado para evitar inyección de SQL
        $documento = $conn->real_escape_string($_POST['documento']);

        // Consulta SQL para obtener el nombre del alumno con el documento proporcionado
        $consulta = "SELECT nombre FROM alumnos WHERE documento_identidad = '$documento'";

        // Ejecutar la consulta
        $resultado = $conn->query($consulta);

        // Verificar si se encontraron resultados
        if ($resultado && $resultado->num_rows > 0) {
            // Obtener los datos del alumno
            $fila = $resultado->fetch_assoc();
            $nombreAlumno = $fila['nombre'];

            // Mostrar los datos del alumno
            ?>
            <h1>Datos del Alumno</h1>
            <p>Nombre: <?php echo $nombreAlumno; ?></p>
            <p>Documento: <?php echo $documento; ?></p>
            
            <h1>Registrar Actividades</h1>
            <form id="actividadesForm" method="post" action="Procesar_actividad.php">
                <h2>Especialidades</h2>
                <?php
                // Mostrar campos para las actividades de cada especialidad
                foreach ($campos as $campo) {
                    echo '<label for="realizadas_' . $campo . '">Realizadas ' . ucwords(str_replace('_', ' ', $campo)) . ':</label>';
                    echo '<input type="number" id="realizadas_' . $campo . '" name="realizadas_' . $campo . '" min="0"><br>';
                }
                ?>
                <h2>Total</h2>
                <label for="realizadas_total">Realizadas Total:</label>
                <input type="number" id="realizadas_total" name="realizadas_total" value="<?php echo calcularTotal(); ?>" min="0" readonly><br>
                <input type="hidden" name="documento" value="<?php echo $documento; ?>">
                <button type="submit" name="registrar_registro">Registrar</button>

            </form>
            <?php
        } else {
            // Si no se encontraron resultados, mostrar un mensaje de error
            echo "<p>No se encontró ningún alumno con el documento proporcionado.</p>";
        }
    } else {
        // Si no se ha enviado el formulario de búsqueda o no se ha especificado un documento, mostrar el formulario de búsqueda
        ?>
        <h1>Buscar Alumno</h1>
        <form method="post" action="">
            <label for="documento">Número de Documento del Alumno:</label>
            <input type="text" id="documento" name="documento">
            <button type="submit" name="buscar_alumno">Buscar</button>
        </form>
        <?php
    }
?>
</div>
<script>
    function calcularTotal() {
        let realizadasTotal = 0;
        <?php
        // Generar el código JavaScript para sumar los valores de las actividades realizadas de todas las especialidades
        foreach ($campos as $campo) {
            echo "realizadasTotal += parseInt(document.getElementById('realizadas_" . $campo . "').value) || 0;\n";
        }
        ?>
        // Actualizar el campo de total
        document.getElementById('realizadas_total').value = realizadasTotal;
    }
</script>

</body>
</html>
