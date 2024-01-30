<?php
include 'config.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $estado = $_POST['estado'];
    $iniciales = $_POST['iniciales'];
    $id = $_POST['id'];
    $rit = $_POST['rit'];
    $era = isset($_POST['era']) ? $_POST['era'] : '0000';
    $tipoTramite = $_POST['tipoTramite'];
    $tipoPlazo = $_POST['tipoPlazo'];
    $fechaFatal = $_POST['fechaFatal'];
    $observacion = $_POST['observacion'];
    $id_unidad = $_POST['id_unidad'];
    try {    
        $sqlSelect = "SELECT id_unidad FROM agenda WHERE id = ?";
        $stmtSelect = $pdo->prepare($sqlSelect);
        $stmtSelect->execute([$id]);
        $resultSelect = $stmtSelect->fetch(PDO::FETCH_ASSOC);
        if ($resultSelect) {
            $id_unidad = $resultSelect['id_unidad'];
            $sqlUpdate = "UPDATE agenda SET estado = ?, iniciales = ?, rit = ?, era = ?, tipotramite = ?, tipoplazo = ?, fechafatal = ?, observacion = ?, id_unidad = ? WHERE id = ?";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $resultUpdate = $stmtUpdate->execute([$estado, $iniciales, $rit, $era, $tipoTramite, $tipoPlazo, $fechaFatal, $observacion, $id_unidad, $id]);

            require('env.php');
            if ($resultUpdate) {
                $response['success'] = true;
                $response['unidad'] = $id_unidad;
                $response['resultUpdate'] = 'Actualización exitosa';
                $response['message'] = 'Evento actualizado correctamente';
                $response['tipoTramite'] = $tipoTramite;
                $response['reload'] = true;
            } else {
                $response['success'] = false;
                $response['message'] = 'Error al actualizar el evento';
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Error: No se encontró la unidad asociada al evento';
        }
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['message'] = 'Error de base de datos: ' . $e->getMessage();
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
