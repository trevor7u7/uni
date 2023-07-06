<?php
require_once '../conexion.php';

// Obtener la conexión
$conexion = new Conexion();
$conn = $conexion->getConnection();

// Crear un estudiante
function createEstudiante($name, $last_name)
{
    global $conn;

    try {
        $query = "INSERT INTO estudiante (name, last_name, created_at, update_at)
                  VALUES (:name, :last_name, NOW(), NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al crear el estudiante: " . $e->getMessage();
        return false;
    }
}

// Obtener información de un estudiante por su ID
function getEstudiante($id)
{
    global $conn;

    try {
        $query = "SELECT * FROM estudiante WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener el estudiante: " . $e->getMessage();
        return false;
    }
}

// Actualizar información de un estudiante
function updateEstudiante($id, $name, $last_name)
{
    global $conn;

    try {
        $query = "UPDATE estudiante SET name = :name, last_name = :last_name, update_at = NOW()
                  WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al actualizar el estudiante: " . $e->getMessage();
        return false;
    }
}

// Eliminar un estudiante por su ID
function deleteEstudiante($id)
{
    global $conn;

    try {
        $query = "DELETE FROM estudiante WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al eliminar el estudiante: " . $e->getMessage();
        return false;
    }
}

// Ejemplo de uso:

// // Crear un estudiante
// createEstudiante('Juan', 'Pérez');

// // Obtener información de un estudiante por su ID
// $estudiante = getEstudiante(1);
// echo "ID: " . $estudiante['id'] . "<br>";
// echo "Nombre: " . $estudiante['name'] . "<br>";
// echo "Apellido: " . $estudiante['last_name'] . "<br>";

// // Actualizar información de un estudiante
// updateEstudiante(1, 'Juan', 'Gómez');

// // Eliminar un estudiante por su ID
// deleteEstudiante(1);
