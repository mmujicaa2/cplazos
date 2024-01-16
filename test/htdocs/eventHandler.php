<?php 
include 'config.php';
$date = date("Y/m/d");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rit = $_POST['rit'];
    $era = $_POST['era'];
    $tipotramite = $_POST['tipotramite'];
    $tipoplazo = $_POST['tipoplazo'];
    $ndias = $_POST['ndias'];
    $fehchaingreso = date("Y/m/d");
    $fechafatal = $_POST['fechafatal'];
    $id_unidad = $_POST['id_unidad'];

    $query = "INSERT INTO agenda (rit, era, tipotramite, tipoplazo, ndias, fehchaingreso, fechafatal, id_unidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $rit, PDO::PARAM_STR);
    $stmt->bindParam(2, $era, PDO::PARAM_STR);
    $stmt->bindParam(3, $tipotramite, PDO::PARAM_STR);
    $stmt->bindParam(4, $tipoplazo, PDO::PARAM_STR);
    $stmt->bindParam(5, $ndias, PDO::PARAM_INT);
    $stmt->bindParam(6, $fehchaingreso, PDO::PARAM_STR);
    $stmt->bindParam(7, $fechafatal, PDO::PARAM_STR);
    $stmt->bindParam(8, $id_unidad, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
       // enviarCorreoPorUnidad($correo, $rit, $era, $tipotramite, $tipoplazo, $ndias, $fehchaingreso, $fechafatal, $pdo);
        header('Location: index.php');
        exit();
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->errorInfo()[2];
    }
}
?>