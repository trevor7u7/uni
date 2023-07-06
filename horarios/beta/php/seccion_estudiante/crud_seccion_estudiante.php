<?php
require_once '../conexion.php';

// Obtener la conexión
$conexion = new Conexion();
$conn = $conexion->getConnection();

// Agregar un estudiante a una sección
function addEstudianteToSeccion($estudianteId, $seccionId)
{
    global $conn;

    try {
        $query = "INSERT INTO seccion_estudiante (estudiante_id, seccion_id) 
                  VALUES (:estudiante_id, :seccion_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudianteId);
        $stmt->bindParam(':seccion_id', $seccionId);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al agregar el estudiante a la sección: " . $e->getMessage();
        return false;
    }
}

// Obtener estudiantes de una sección
function getEstudiantesFromSeccion($seccionId)
{
    global $conn;

    try {
        $query = "SELECT * FROM seccion_estudiante WHERE seccion_id = :seccion_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':seccion_id', $seccionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los estudiantes de la sección: " . $e->getMessage();
        return false;
    }
}
// Actualizar un estudiante en una sección
function updateEstudianteInSeccion($id, $estudianteId, $seccionId)
{
    global $conn;

    try {
        $query = "UPDATE seccion_estudiante 
                  SET estudiante_id = :estudiante_id, seccion_id = :seccion_id, updated_at = NOW() 
                  WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudianteId);
        $stmt->bindParam(':seccion_id', $seccionId);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al actualizar el estudiante en la sección: " . $e->getMessage();
        return false;
    }
}

// Eliminar un estudiante de una sección
function removeEstudianteFromSeccion($estudianteId, $seccionId)
{
    global $conn;

    try {
        $query = "DELETE FROM seccion_estudiante WHERE estudiante_id = :estudiante_id AND seccion_id = :seccion_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudianteId);
        $stmt->bindParam(':seccion_id', $seccionId);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al eliminar el estudiante de la sección: " . $e->getMessage();
        return false;
    }
}

// Ejemplo de uso:

// // Agregar un estudiante a una sección
// addEstudianteToSeccion(1, 1);

// // Obtener estudiantes de una sección
// $estudiantes = getEstudiantesFromSeccion(1);
// foreach ($estudiantes as $estudiante) {
//     echo "ID: " . $estudiante['id'] . "<br>";
//     echo "Estudiante ID: " . $estudiante['estudiante_id'] . "<br>";
//     echo "Sección ID: " . $estudiante['seccion_id'] . "<br>";
//     echo "Fecha de creación: " . $estudiante['created_at'] . "<br>";
//     echo "Fecha de actualización: " . $estudiante['updated_at'] . "<br>";
//     echo "<br>";
// }

// // Ejemplo de uso:

// // Actualizar un estudiante en una sección
// updateEstudianteInSeccion(1, 2, 2);

// // Eliminar un estudiante de una sección
// removeEstudianteFromSeccion(1, 1);
