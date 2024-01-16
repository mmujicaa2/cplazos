<?php
include 'config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $rit = $_POST['rit'];
    $ano = $_POST['ano'];
    $tipoTramite = $_POST['tipoTramite'];
    $tipoPlazo = $_POST['tipoPlazo'];
    $fechaFatal = $_POST['fechaFatal'];

    error_log("Fecha Fatal recibida: " . $fechaFatal);

    $sql = "UPDATE agenda SET rit = ?, era = ?, tipotramite = ?, tipoplazo = ?, fechafatal = ? WHERE id = ?";
    
    try {
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$rit, $ano, $tipoTramite, $tipoPlazo, $fechaFatal, $id]);

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
}

header('Content-Type: application/json');
echo json_encode($response);
?>
