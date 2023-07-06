<?php
require_once '../conexion.php';

// Obtener la conexión
$conexion = new Conexion();
$conn = $conexion->getConnection();

// Agregar disponibilidad de un profesor
function addProfesorDisponibilidad($profesorId, $hour, $disponibilidad, $tipo_horario)
{
    global $conn;

    try {
        $query = "INSERT INTO profesor_disponibilidad (profesor_id, hour, disponibilidad, tipo_horario) 
                  VALUES (:profesor_id, :hour, :disponibilidad, :tipo_horario)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':profesor_id', $profesorId);
        $stmt->bindParam(':hour', $hour);
        $stmt->bindParam(':disponibilidad', $disponibilidad);
        $stmt->bindParam(':tipo_horario', $tipo_horario);

        $stmt->execute();

        $response = array(
            'success' => true
        );
        $jsonResponse = json_encode($response);
        header('Content-Type: application/json');
        echo $jsonResponse;
    } catch (PDOException $e) {
        $response = array(
            'success' => false,
            'message' => 'Error al agregar la disponibilidad del profesor: ' . $e->getMessage()
        );
        $jsonResponse = json_encode($response);
        header('Content-Type: application/json');
        echo $jsonResponse;
    }
}

// Obtener disponibilidad de un profesor por su ID
function getProfesorDisponibilidad($profesor_id, $tipo_horario)
{
    global $conn;

    try {
        $query = "SELECT disponibilidad, hour, tipo_horario FROM profesor_disponibilidad
        WHERE profesor_id = :profesor_id AND tipo_horario = :tipo_horario";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':profesor_id', $profesor_id);
        $stmt->bindParam(':tipo_horario', $tipo_horario);

        $stmt->execute();

        $response = array(
            'success' => true,
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
        $jsonResponse = json_encode($response);
        header('Content-Type: application/json');
        echo $jsonResponse;
    } catch (PDOException $e) {
        $response = array(
            'success' => false,
            'message' => 'Error al obtener la disponibilidad del profesor: ' . $e->getMessage()
        );
        $jsonResponse = json_encode($response);
        header('Content-Type: application/json');
        echo $jsonResponse;
    }
}

// Actualizar disponibilidad de un profesor
function updateProfesorDisponibilidad($profesorId, $hour, $disponibilidad, $tipoH)
{
    global $conn;

    try {
        $query = "UPDATE profesor_disponibilidad 
                  SET hour = :hour, disponibilidad = :disponibilidad, update_at = NOW(), tipo_horario = :tipo_horario 
                  WHERE profesor_id = :profesor_id AND hour = :hour 
                  AND tipo_horario = :tipo_horario";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':hour', $hour);
        $stmt->bindParam(':disponibilidad', $disponibilidad);
        $stmt->bindParam(':profesor_id', $profesorId);
        $stmt->bindParam(':tipo_horario', $tipoH);

        $stmt->execute();

        $response = array(
            'success' => true
        );
        $jsonResponse = json_encode($response);
        header('Content-Type: application/json');
        echo $jsonResponse;
    } catch (PDOException $e) {
        $response = array(
            'success' => false,
            'message' => 'Error al actualizar la disponibilidad del profesor: ' . $e->getMessage()
        );
        $jsonResponse = json_encode($response);
        header('Content-Type: application/json');
        echo $jsonResponse;
    }
}

// Eliminar disponibilidad de un profesor por su ID
function deleteProfesorDisponibilidad($id)
{
    global $conn;

    try {
        $query = "DELETE FROM profesor_disponibilidad WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error al eliminar la disponibilidad del profesor: " . $e->getMessage();
        return false;
    }
}
function getProfesor($id)
{
    global $conn;

    try {
        $query = "SELECT name, last_name FROM profesor WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $rowCount = $stmt->rowCount();


        if ($rowCount == 0) {
            return 404;
        } else {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        echo "Error al obtener el profesor: " . $e->getMessage();
        return false;
    }
}
function geT($id)
{
    $profesor = getProfesor($id);
    $response = array('profesor' => $profesor);
    // Convertir el array en formato JSON

    if ($response['profesor'] == 404) {
        http_response_code(404);
        $response = array(
            'success' => false,
            'menssage' => 'No Found'
        );
    } else {
        http_response_code(200);
        $response = array(
            'success' => true,
            'profesor' => $profesor
        );
    }
    $jsonResponse = json_encode($response);

    // Imprimir el JSON como respuesta
    header('Content-Type: application/json');
    echo $jsonResponse;
}

function verificar($profesorId, $posicion, $disponibilidad, $tipoH)
{
    global $conn;

    try {
        $query = "SELECT id FROM profesor_disponibilidad WHERE 
        profesor_id = :id AND 
        tipo_horario = :tipoh AND
        hour = :posicion";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $profesorId);
        $stmt->bindParam(':tipoh', $tipoH);
        $stmt->bindParam(':posicion', $posicion);

        $stmt->execute();
        $rowCount = $stmt->rowCount();

        // si el rowCount es cero, se crea la disponibilidad, de lo contrario
        // se actualiza

        if ($rowCount == 0) {
            addProfesorDisponibilidad($profesorId, $posicion, $disponibilidad, $tipoH);
        } else {
            updateProfesorDisponibilidad($profesorId, $posicion, $disponibilidad, $tipoH);
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}


switch ($_POST['tipo']) {
    case 'mostrar_name':
        geT($_POST['id']);
        break;

    case 'verificar':
        $datos = $_POST['datos'];
        verificar($_POST['id'], $datos['posicion'], $datos['disponibilidad'], $datos['tipoh']);
        break;

    case 'cargar_tabla':
        getProfesorDisponibilidad($_POST['id'], $_POST['horario']);
        break;

    default:
        # code...
        break;
}



// Ejemplo de uso:

// Agregar disponibilidad de un profesor
// addProfesorDisponibilidad(1, '10:00', true);

// // Obtener disponibilidad de un profesor
// $disponibilidad = getProfesorDisponibilidad(1);
// echo "ID: " . $disponibilidad['id'] . "<br>";
// echo "Profesor ID: " . $disponibilidad['profesor_id'] . "<br>";
// echo "Hora: " . $disponibilidad['hour'] . "<br>";
// echo "Disponibilidad: " . ($disponibilidad['disponibilidad'] ? 'Disponible' : 'No disponible') . "<br>";
// echo "Fecha de creación: " . $disponibilidad['created_at'] . "<br>";
// echo "Fecha de actualización: " . $disponibilidad['update_at'] . "<br>";
// echo "<br>";

// // Actualizar disponibilidad de un profesor
// updateProfesorDisponibilidad(1, '11:00', false);

// // Eliminar disponibilidad de un profesor
// deleteProfesorDisponibilidad(1);
