<?php
// Datos de conexión a la base de datos
$host = 'localhost'; // Cambia esto si tu servidor de PostgreSQL está en otro host
$dbname = 'sarec';
$user = 'postgres'; //
$password = '123';

$db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);

// ID del estudiante a obtener
$student_id = $_GET['id'];

// Consulta SQL para obtener la información del estudiante
$query = "SELECT * FROM estudiante WHERE id = :id";

// Preparar la consulta
$stmt = $db->prepare($query);

// Asignar valor al parámetro
$stmt->bindParam(':id', $student_id);

// Ejecutar la consulta
$stmt->execute();

// Obtener los datos del estudiante
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// Mostrar los datos en una página o realizar otras acciones deseadas
echo "Nombre: " . $student['name'];
echo "Apellido: " . $student['last_name'];
