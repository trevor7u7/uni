<?php
require_once '../conexion.php';

// Obtener la conexión
$conexion = new Conexion();
$conn = $conexion->getConnection();

// Agregar un pensum
function addPensum($name, $pnf, $trayecto)
{
    global $conn;

    try {
        $query = "INSERT INTO pensum (name, pnf, trayecto) VALUES (:name, :pnf, :trayecto)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':pnf', $pnf);
        $stmt->bindParam(':trayecto', $trayecto);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al agregar el pensum: " . $e->getMessage();
        return false;
    }
}

// Obtener un pensum por su ID
function getPensum($id)
{
    global $conn;

    try {
        $query = "SELECT * FROM pensum WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener el pensum: " . $e->getMessage();
        return false;
    }
}

// Actualizar un pensum
function updatePensum($id, $name, $pnf, $trayecto)
{
    global $conn;

    try {
        $query = "UPDATE pensum SET name = :name, pnf = :pnf, trayecto = :trayecto, update_at = NOW() WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':pnf', $pnf);
        $stmt->bindParam(':trayecto', $trayecto);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al actualizar el pensum: " . $e->getMessage();
        return false;
    }
}

// Eliminar un pensum por su ID
function deletePensum($id)
{
    global $conn;

    try {
        $query = "DELETE FROM pensum WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al eliminar el pensum: " . $e->getMessage();
        return false;
    }
}

// Ejemplo de uso:

// // Agregar un pensum
// addPensum('Pensum A', 'PNF1', 'Trayecto 1');

// // Obtener un pensum
// $pensum = getPensum(1);
// echo "ID: " . $pensum['id'] . "<br>";
// echo "Nombre: " . $pensum['name'] . "<br>";
// echo "PNF: " . $pensum['pnf'] . "<br>";
// echo "Trayecto: " . $pensum['trayecto'] . "<br>";
// echo "Fecha de creación: " . $pensum['created_at'] . "<br>";
// echo "Fecha de actualización: " . $pensum['update_at'] . "<br>";
// echo "<br>";

// // Actualizar un pensum
// updatePensum(1, 'Pensum B', 'PNF2', 'Trayecto 2');

// // Eliminar un pensum
// deletePensum(1);
