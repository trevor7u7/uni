<?php
$db = new PDO('pgsql:host=localhost;dbname=sarec', 'postgres', '123');
// ID de la sección a obtener
$seccion_id = $_GET['id'];

// Consulta SQL para obtener la información de la sección
$query = "SELECT * FROM seccion WHERE id = :id";

// Preparar la consulta
$stmt = $db->prepare($query);

// Asignar valor al parámetro
$stmt->bindParam(':id', $seccion_id);

// Ejecutar la consulta
$stmt->execute();

// Obtener los datos de la sección
$seccion = $stmt->fetch(PDO::FETCH_ASSOC);

// Mostrar los datos en una página o realizar otras acciones deseadas
echo "PNF: " . $seccion['pnf'];
echo "Trayecto: " . $seccion['trayecto'];
