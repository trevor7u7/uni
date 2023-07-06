<?php
// Conexión a la base de datos
$db = new PDO('pgsql:host=localhost;dbname=sarec', 'postgres', '123');

// Datos actualizados del estudiante
$name = $_POST['name'];
$last_name = $_POST['last_name'];
$seccion_id = $_POST['seccion_id'];
$student_id = $_POST['student_id'];

// Consulta SQL para actualizar el estudiante
$query = "UPDATE estudiante SET name = :name, last_name = :last_name, seccion_id = :seccion_id, update_at = NOW()
          WHERE id = :id";

// Preparar la consulta
$stmt = $db->prepare($query);

// Asignar valores a los parámetros
$stmt->bindParam(':name', $name);
$stmt->bindParam(':last_name', $last_name);
$stmt->bindParam(':seccion_id', $seccion_id);
$stmt->bindParam(':id', $student_id);

// Ejecutar la consulta
$stmt->execute();

// Redirigir a la página de lista de estudiantes u otra ubicación deseada
header('Location: lista_estudiantes.php');
exit();
