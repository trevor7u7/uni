<?php
require_once '../conexion.php';

// Obtener la conexión
$conexion = new Conexion();
$conn = $conexion->getConnection();

// Agregar un director
function addDirector($name, $last_name, $pnf)
{
    global $conn;

    try {
        $query = "INSERT INTO director (name, last_name, pnf) 
                  VALUES (:name, :last_name, :pnf)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':pnf', $pnf);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al agregar el director: " . $e->getMessage();
        return false;
    }
}

// Obtener un director por su ID
function getDirector($id)
{
    global $conn;

    try {
        $query = "SELECT * FROM director WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener el director: " . $e->getMessage();
        return false;
    }
}

// Actualizar un director
function updateDirector($id, $name, $last_name, $pnf)
{
    global $conn;

    try {
        $query = "UPDATE director 
                  SET name = :name, last_name = :last_name, pnf = :pnf, update_at = NOW() 
                  WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':pnf', $pnf);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al actualizar el director: " . $e->getMessage();
        return false;
    }
}

// Eliminar un director por su ID
function deleteDirector($id)
{
    global $conn;

    try {
        $query = "DELETE FROM director WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al eliminar el director: " . $e->getMessage();
        return false;
    }
}

// Ejemplo de uso:

// // Agregar un director
// addDirector('John', 'Doe', 'PNF001');

// // Obtener un director
// $director = getDirector(1);
// echo "ID: " . $director['id'] . "<br>";
// echo "Nombre: " . $director['name'] . "<br>";
// echo "Apellido: " . $director['last_name'] . "<br>";
// echo "PNF: " . $director['pnf'] . "<br>";
// echo "Fecha de creación: " . $director['created_at'] . "<br>";
// echo "Fecha de actualización: " . $director['update_at'] . "<br>";
// echo "<br>";

// // Actualizar un director
// updateDirector(1, 'Jane', 'Smith', 'PNF002');

// // Eliminar un director
// deleteDirector(1);
