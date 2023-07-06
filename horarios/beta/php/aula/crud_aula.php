<?php
require_once '../conexion.php';

// Obtener la conexión
$conexion = new Conexion();
$conn = $conexion->getConnection();

// Agregar un aula
function addAula($name, $capacity) {
    global $conn;

    try {
        $query = "INSERT INTO aula (name, capacity) VALUES (:name, :capacity)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':capacity', $capacity);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al agregar el aula: " . $e->getMessage();
        return false;
    }
}

// Obtener un aula por su ID
function getAula($id) {
    global $conn;

    try {
        $query = "SELECT * FROM aula WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener el aula: " . $e->getMessage();
        return false;
    }
}

// Actualizar un aula
function updateAula($id, $name, $capacity) {
    global $conn;

    try {
        $query = "UPDATE aula SET name = :name, capacity = :capacity, update_at = NOW() WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':capacity', $capacity);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al actualizar el aula: " . $e->getMessage();
        return false;
    }
}

// Eliminar un aula por su ID
function deleteAula($id) {
    global $conn;

    try {
        $query = "DELETE FROM aula WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al eliminar el aula: " . $e->getMessage();
        return false;
    }
}

// Ejemplo de uso:

// // Agregar un aula
// addAula('Aula 101', 50);

// // Obtener un aula
// $aula = getAula(1);
// echo "ID: " . $aula['id'] . "<br>";
// echo "Nombre: " . $aula['name'] . "<br>";
// echo "Capacidad: " . $aula['capacity'] . "<br>";
// echo "Fecha de creación: " . $aula['created_at'] . "<br>";
// echo "Fecha de actualización: " . $aula['update_at'] . "<br>";
// echo "<br>";

// // Actualizar un aula
// updateAula(1, 'Aula 102', 60);

// // Eliminar un aula
// deleteAula(1);
