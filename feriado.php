<?php
include 'config.php';

if (isset($_POST['fecha'])) {
    $fecha = $_POST['fecha'];
    $sql = "SELECT * FROM feriados WHERE start = :fecha";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->execute();
    $feriado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($feriado) {
        echo json_encode(['esFeriado' => true]);
    } else {
        echo json_encode(['esFeriado' => false]);
    }
} else {
    echo json_encode(['error' => 'Fecha no proporcionada']);
}
?>
