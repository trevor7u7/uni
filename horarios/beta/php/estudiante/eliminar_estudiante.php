<?php
// Conexión a la base de datos
$db = new PDO('pgsql:host=localhost;dbname=sarec', 'postgres', '123');

// ID del estudiante a eliminar
$student_id = $_GET['id'];

// Consulta SQL para eliminar el estudiante
$query = "DELETE FROM estudiante WHERE id = :id";

// Preparar la consulta
$stmt = $db->prepare($query);

// Asignar valor al parámetro
$stmt->bindParam(':id', $student_id);

// Ejecutar la consulta
$stmt->execute();

// Redirigir a la página de lista de estudiantes u otra ubicación deseada
header('Location: lista_estudiantes.php');
exit();
