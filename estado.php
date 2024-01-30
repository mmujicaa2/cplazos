<?php
include 'config.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nuevoEstado = $_POST['nuevoEstado'];

    $sql = "UPDATE agenda SET estado = ? WHERE id = ?";
    
    try {
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$nuevoEstado, $id]);

        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Actualización exitosa.';
        } else {
            $response['success'] = false;
            $response['message'] = 'No se pudo actualizar el registro.';
        }
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['message'] = 'Error de base de datos: ' . $e->getMessage();
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Método no permitido';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
