<?php 
include 'config.php';
$date = date('Y-m-d', strtotime($date));
//----------------------------------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $iniciales = $_POST['iniciales'];

    $rit = $_POST['rit'];
    $era = isset($_POST['era']) ? $_POST['era'] : '0';
    $tipotramite = $_POST['tipotramite'];
    $tipoplazo = $_POST['tipoplazo'];
    $ndias = $_POST['ndias'];
    $fehchaingreso = date('Y-m-d', strtotime($_POST['fehchaingreso'] . ' +0 day'));
    $fechafatal = date('Y-m-d', strtotime($_POST['fechafatal'] . ' +0 day'));
    $id_unidad = $_POST['id_unidad'];
    $observacion = $_POST['observacion'];
    $estado = $_POST['estado'];
    $correocc = $_POST['correocc'];

    $query = "INSERT INTO agenda (iniciales, rit, era, tipotramite, tipoplazo, ndias, fehchaingreso, fechafatal, id_unidad, observacion, estado, correocc) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pendiente', ?)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $iniciales, PDO::PARAM_STR);
    $stmt->bindParam(2, $rit, PDO::PARAM_STR);
    $stmt->bindParam(3, $era, PDO::PARAM_STR);
    $stmt->bindParam(4, $tipotramite, PDO::PARAM_STR);
    $stmt->bindParam(5, $tipoplazo, PDO::PARAM_STR);
    $stmt->bindParam(6, $ndias, PDO::PARAM_INT);
    $stmt->bindParam(7, $fehchaingreso, PDO::PARAM_STR);
    $stmt->bindParam(8, $fechafatal, PDO::PARAM_STR);
    $stmt->bindParam(9, $id_unidad, PDO::PARAM_STR);
    $stmt->bindParam(10, $observacion, PDO::PARAM_STR);
    $stmt->bindParam(11, $correocc, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        header('Location: index.php');
        
date_default_timezone_set("America/Santiago");
$fechaYHora = date("Y-m-d H:i:s");
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? null;
$ip = $ip ?: "Desconocida";
$accion = "Añadir";

$query = "INSERT INTO visitas (fecha, ip, accion) VALUES (?, ?, ?)";

$stmt = $pdo->prepare($query);
$stmt->bindParam(1, $fechaYHora, PDO::PARAM_STR);
$stmt->bindParam(2, $ip, PDO::PARAM_STR);
$stmt->bindParam(3, $accion, PDO::PARAM_STR);

if ($stmt->execute()) {
  require('enviar1.php');
    $response['success'] = true;
    $response['message'] = 'Añadir exitosa.';
    exit();
} else {
    echo "Error al ejecutar la consulta: " . $stmt->errorInfo()[2];
}
        exit();
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->errorInfo()[2];
    }
}
?>