<?php

$db = new PDO('pgsql:host=localhost;dbname=sarec', 'postgres', '123');


// ID de la sección a eliminar
$seccion_id = $_GET['id'];

// Consulta SQL para eliminar la sección
$query = "DELETE FROM seccion WHERE id = :id";

// Preparar la consulta
$stmt = $db->prepare($query);

// Asignar valor al parámetro
$stmt->bindParam(':id', $seccion_id);

// Ejecutar la consulta
$stmt->execute();

// Redirigir a la página de lista de secciones u otra ubicación deseada
header('Location: r_seccion.php');
exit();
