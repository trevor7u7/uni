<?php
// Conexión a la base de datos
$db = new PDO('pgsql:host=localhost;dbname=sarec', 'postgres', '123');

// Datos del estudiante
$name = $_POST['name'];
$last_name = $_POST['last_name'];

// Consulta SQL para insertar el estudiante
$query = "INSERT INTO estudiante (name, last_name, created_at, update_at)
          VALUES (:name, :last_name,  NOW(), NOW())";

// Preparar la consulta
$stmt = $db->prepare($query);

// Asignar valores a los parámetros
$stmt->bindParam(':name', $name);
$stmt->bindParam(':last_name', $last_name);

// Ejecutar la consulta
$stmt->execute();

// Redirigir a la página de lista de estudiantes u otra ubicación deseada
header('Location: lista_estudiante.php');
exit();
