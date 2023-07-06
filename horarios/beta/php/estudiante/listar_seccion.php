<?php
// Datos de conexión a la base de datos
$host = 'localhost';
$dbname = 'sarec';
$user = 'postgres';
$password = '123';

$db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);

$query = "SELECT seccion.id, seccion.pnf FROM seccion";

// Preparar la consulta
$stmt = $db->prepare($query);

// Ejecutar la consulta
$stmt->execute();

$rowCount = $stmt->rowCount();

if ($rowCount == 0) {
    http_response_code(404);
    $response = array('error' => '404');
    $jsonResponse = json_encode($response);

    // Imprimir el JSON como respuesta
    header('Content-Type: application/json');
    echo $jsonResponse;
} else {
    $response = array('student' => $student);
    // Convertir el array en formato JSON
    $jsonResponse = json_encode($response);

    // Imprimir el JSON como respuesta
    header('Content-Type: application/json');
    echo $jsonResponse;
}
