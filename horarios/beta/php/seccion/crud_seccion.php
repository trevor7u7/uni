<?php
require_once '../conexion.php';

// Obtener la conexión
$conexion = new Conexion();
$conn = $conexion->getConnection();

// Agregar una sección
function addSeccion($pnf, $trayecto)
{
    global $conn;

    try {
        $query = "INSERT INTO seccion (pnf, trayecto) VALUES (:pnf, :trayecto)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':pnf', $pnf);
        $stmt->bindParam(':trayecto', $trayecto);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al agregar la sección: " . $e->getMessage();
        return false;
    }
}

// Obtener una sección por su ID
function getSeccion($id)
{
    global $conn;

    try {
        $query = "SELECT * FROM seccion WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener la sección: " . $e->getMessage();
        return false;
    }
}

// Actualizar una sección
function updateSeccion($id, $pnf, $trayecto)
{
    global $conn;

    try {
        $query = "UPDATE seccion SET pnf = :pnf, trayecto = :trayecto, update_at = NOW() WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':pnf', $pnf);
        $stmt->bindParam(':trayecto', $trayecto);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al actualizar la sección: " . $e->getMessage();
        return false;
    }
}

// Eliminar una sección por su ID
function deleteSeccion($id)
{
    global $conn;

    try {
        $query = "DELETE FROM seccion WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al eliminar la sección: " . $e->getMessage();
        return false;
    }
}

// Ejemplo de uso:

// // Agregar una sección
// addSeccion('PNF001', 'Trayecto 1');

// // Obtener una sección
// $seccion = getSeccion(1);
// echo "ID: " . $seccion['id'] . "<br>";
// echo "PNF: " . $seccion['pnf'] . "<br>";
// echo "Trayecto: " . $seccion['trayecto'] . "<br>";
// echo "Fecha de creación: " . $seccion['created_at'] . "<br>";
// echo "Fecha de actualización: " . $seccion['update_at'] . "<br>";
// echo "<br>";

// // Actualizar una sección
// updateSeccion(1, 'PNF002', 'Trayecto 2');

// // Eliminar una sección
// deleteSeccion(1);
