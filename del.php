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
            // Registro en la tabla visitas
            date_default_timezone_set("America/Santiago");
            $fechaYHora = date("Y-m-d H:i:s");
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? null;
            $ip = $ip ?: "Desconocida";
            $accion = "Eliminar";

            $queryVisitas = "INSERT INTO visitas (fecha, ip, accion, id) VALUES (?, ?, ?,?)";
            $stmtVisitas = $pdo->prepare($queryVisitas);
            $stmtVisitas->bindParam(1, $fechaYHora, PDO::PARAM_STR);
            $stmtVisitas->bindParam(2, $ip, PDO::PARAM_STR);
            $stmtVisitas->bindParam(3, $accion, PDO::PARAM_STR);
            $stmtVisitas->bindParam(4, $id, PDO::PARAM_INT);
            if ($stmtVisitas->execute()) {
                $response['success'] = true;
                $response['message'] = 'Eliminación exitosa.';
            } else {
                $response['success'] = false;
                $response['message'] = 'Error al registrar la eliminación en la tabla visitas: ' . $stmtVisitas->errorInfo()[2];
            }
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