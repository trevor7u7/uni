<?php
$db = new PDO('pgsql:host=localhost;dbname=sarec', 'postgres', '123');

// Datos actualizados de la sección
$pnf = $_POST['pnf'];
$trayecto = $_POST['trayecto'];
$seccion_id = $_POST['seccion_id'];

// Consulta SQL para actualizar la sección
$query = "UPDATE seccion SET pnf = :pnf, trayecto = :trayecto, update_at = NOW()
          WHERE id = :id";

// Preparar la consulta
$stmt = $db->prepare($query);

// Asignar valores a los parámetros
$stmt->bindParam(':pnf', $pnf);
$stmt->bindParam(':trayecto', $trayecto);
$stmt->bindParam(':id', $seccion_id);

// Ejecutar la consulta
$stmt->execute();

// Redirigir a la página de lista de secciones u otra ubicación deseada
header('Location: r_seccion.php');
exit();
