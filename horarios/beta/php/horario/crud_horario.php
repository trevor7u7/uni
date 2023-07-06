<?php
require_once '../conexion.php';

// Obtener la conexión
$conexion = new Conexion();
$conn = $conexion->getConnection();

// Agregar un horario
function addHorario($pensum_id, $profesor_id, $aula_id, $director_id, $pnf, $hour) {
    global $conn;

    try {
        $query = "INSERT INTO horario (pensum_id, profesor_id, aula_id, director_id, pnf, hour) 
                  VALUES (:pensum_id, :profesor_id, :aula_id, :director_id, :pnf, :hour)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':pensum_id', $pensum_id);
        $stmt->bindParam(':profesor_id', $profesor_id);
        $stmt->bindParam(':aula_id', $aula_id);
        $stmt->bindParam(':director_id', $director_id);
        $stmt->bindParam(':pnf', $pnf);
        $stmt->bindParam(':hour', $hour);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al agregar el horario: " . $e->getMessage();
        return false;
    }
}

// Obtener un horario por su ID
function getHorario($id) {
    global $conn;

    try {
        $query = "SELECT * FROM horario WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener el horario: " . $e->getMessage();
        return false;
    }
}

// Actualizar un horario
function updateHorario($id, $pensum_id, $profesor_id, $aula_id, $director_id, $pnf, $hour) {
    global $conn;

    try {
        $query = "UPDATE horario 
                  SET pensum_id = :pensum_id, profesor_id = :profesor_id, aula_id = :aula_id, 
                      director_id = :director_id, pnf = :pnf, hour = :hour, update_at = NOW() 
                  WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':pensum_id', $pensum_id);
        $stmt->bindParam(':profesor_id', $profesor_id);
        $stmt->bindParam(':aula_id', $aula_id);
        $stmt->bindParam(':director_id', $director_id);
        $stmt->bindParam(':pnf', $pnf);
        $stmt->bindParam(':hour', $hour);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al actualizar el horario: " . $e->getMessage();
        return false;
    }
}

// Eliminar un horario por su ID
function deleteHorario($id) {
    global $conn;

    try {
        $query = "DELETE FROM horario WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al eliminar el horario: " . $e->getMessage();
        return false;
    }
}

// Ejemplo de uso:

// // Agregar un horario
// addHorario(1, 1, 1, 1, 'PNF001', 8);

// // Obtener un horario
// $horario = getHorario(1);
// echo "ID: " . $horario['id'] . "<br>";
// echo "Pensum ID: " . $horario['pensum_id'] . "<br>";
// echo "Profesor ID: " . $horario['profesor_id'] . "<br>";
// echo "Aula ID: " . $horario['aula_id'] . "<br>";
// echo "Director ID: " . $horario['director_id'] . "<br>";
// echo "PNF: " . $horario['pnf'] . "<br>";
// echo "Hora: " . $horario['hour'] . "<br>";
// echo "Fecha de creación: " . $horario['created_at'] . "<br>";
// echo "Fecha de actualización: " . $horario['update_at'] . "<br>";
// echo "<br>";

// // Actualizar un horario
// updateHorario(1, 2, 2, 2, 2, 'PNF002', 10);

// // Eliminar un horario
// deleteHorario(1);
