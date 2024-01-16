<?php
include 'config.php';

$query = "SELECT * FROM agenda";
$stmt = $pdo->prepare($query);
$stmt->execute();
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$eventos_calendario = [];
foreach ($eventos as $evento) {
    $descripcion = "RIT: {$evento['rit']}
    \nAño: {$evento['era']}
    \nTipo de Trámite: {$evento['tipotramite']}
    \nTipo de Plazo: {$evento['tipoplazo']}
    \nNúmero de Días: {$evento['ndias']}
    \nFecha de Ingreso: {$evento['fehchaingreso']}
    \nFecha Fatal: {$evento['fechafatal']}
    \nid: {$evento['id']}
    \nCorreo: {$evento['id_unidad']}";
    
    $evento_calendario = [
        'title' => $evento['tipotramite'],
        'start' => $evento['fehchaingreso'],
        'end' => $evento['fechafatal'],
        'description' => $descripcion,
    ];
    $eventos_calendario[] = $evento_calendario;
}

?>