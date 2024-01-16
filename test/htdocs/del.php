<?php
include 'config.php';
$response = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM agenda WHERE id = ?";
    try {
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$id]);
       
        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Eliminación exitosa.';
        } else {
            $response['success'] = false;
            $response['message'] = 'No se pudo eliminar el registro.';
        }
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['message'] = 'Error de base de datos: ' . $e->getMessage();
        echo json_encode($response);
        exit;
    }
}
header('Content-Type: application/json');
echo json_encode($response);
?>