<?php

$db = new PDO('pgsql:host=localhost;dbname=sarec', 'postgres', '123');

// Datos de la sección
$pnf = $_POST['pnf'];
$trayecto = $_POST['trayecto'];

// Consulta SQL para insertar la sección
$query = "INSERT INTO seccion (pnf, trayecto, created_at, update_at)
VALUES (:pnf, :trayecto, NOW(), NOW())";

// Preparar la consulta
$stmt = $db->prepare($query);

// Asignar valores a los parámetros
$stmt->bindParam(':pnf', $pnf);
$stmt->bindParam(':trayecto', $trayecto);

// Ejecutar la consulta
$stmt->execute();

// Redirigir a la página de lista de secciones u otra ubicación deseada
header('Location: r_seccion.php');
exit();
