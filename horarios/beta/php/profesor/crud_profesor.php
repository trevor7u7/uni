<?php
require_once '../conexion.php';

// Obtener la conexión
$conexion = new Conexion();
$conn = $conexion->getConnection();

// Crear un profesor
function createProfesor($name, $last_name, $perfil)
{
    global $conn;

    try {
        $query = "INSERT INTO profesor (name, last_name, perfil, created_at, update_at)
                  VALUES (:name, :last_name, :perfil, NOW(), NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':perfil', $perfil);
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
            'message' => 'Error al "crear" el profesor: ' . $e->getMessage()
        );
        $jsonResponse = json_encode($response);
        header('Content-Type: application/json');
        echo $jsonResponse;
    }
}

// Obtener información de un profesor por su ID
function getProfesor($id)
{
    global $conn;

    try {
        $query = "SELECT id, name, last_name, perfil FROM profesor WHERE id = :id";
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

// Listar Profesores

function listarProfesores()
{
    global $conn;

    try {
        $query = "SELECT id, name, last_name, perfil FROM profesor ORDER BY id";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $rowCount = $stmt->rowCount();

        if ($rowCount == 0) {
            return 404;
        } else {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        echo "Error al obtener los profesores: " . $e->getMessage();
        return false;
    }
}


// Actualizar información de un profesor
function updateProfesor($id, $name, $last_name, $perfil)
{
    global $conn;

    try {
        $query = "UPDATE profesor SET name = :name, last_name = :last_name, perfil = :perfil, update_at = NOW()
                  WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':perfil', $perfil);
        $stmt->bindParam(':id', $id);
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
            'message' => 'Error al actualizar el profesor: ' . $e->getMessage()
        );
        $jsonResponse = json_encode($response);
        header('Content-Type: application/json');
        echo $jsonResponse;
    }
}

// Eliminar un profesor por su ID
function deleteProfesor($id)
{
    global $conn;

    try {
        $query = "DELETE FROM profesor WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
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
            'message' => 'Error al actualizar el profesor: ' . $e->getMessage()
        );
        $jsonResponse = json_encode($response);
        header('Content-Type: application/json');
        echo $jsonResponse;
    }
}

function listProf()
{
    $profesores = listarProfesores();


    $response = array(
        'success' => true,
        'profesores' => $profesores
    );
    // Convertir el array en formato JSON
    $jsonResponse = json_encode($response);

    if ($response['profesores'] == 404) {
        http_response_code(404);
    }

    // Imprimir el JSON como respuesta
    header('Content-Type: application/json');
    echo $jsonResponse;
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
            'success' => false,
            'profesor' => $profesor
        );
    }
    $jsonResponse = json_encode($response);

    // Imprimir el JSON como respuesta
    header('Content-Type: application/json');
    echo $jsonResponse;
}

switch ($_POST['tipo']) {
    case 'crear':
        createProfesor($_POST['name'], $_POST['last_name'], $_POST['perfil']);
        break;
    case 'actualizar':
        updateProfesor($_POST['id'], $_POST['name'], $_POST['last_name'], $_POST['perfil']);
        break;
    case 'eliminar':
        deleteProfesor($_POST['id']);
        break;
    case 'listar':
        listProf();
        break;
    case 'listar_uno':
        geT($_POST['id']);
        break;
    default:
        echo '401';
        break;
}
