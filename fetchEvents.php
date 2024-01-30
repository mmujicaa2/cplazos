<?php
include 'config.php';

$queryFeriados = "SELECT * FROM feriados";
$stmtFeriados = $pdo->prepare($queryFeriados);
$stmtFeriados->execute();
$feriados = $stmtFeriados->fetchAll(PDO::FETCH_ASSOC);

$eventos_calendario = [];

foreach ($feriados as $feriado) {
    $descripcion = "Feriado: {$feriado['title']}
    \nInicio: {$feriado['start']}
    \nFin: {$feriado['end']}";

    $feriado_calendario = [
        'title' => $feriado['title'],
        'start' => $feriado['start'],
        'end' => $feriado['end'],
        'description' => $descripcion,
        'color' => '#000000', 
        'display' => 'background',
    ];
    $eventos_calendario[] = $feriado_calendario;
}
$queryEventos = "SELECT * FROM agenda";
$stmtEventos = $pdo->prepare($queryEventos);
$stmtEventos->execute();
$eventos = $stmtEventos->fetchAll(PDO::FETCH_ASSOC);

function obtenerColorPorIdUnidad($id_unidad) {
    switch ($id_unidad) {
        case 1:
            return '#0000FF'; //unidad sala
        case 2:
            return '#800080'; //unidad servicios y cumplimiento 
        case 3:
            return '#000000'; //unidad de causas 
        case 4:
            return '#000FF'; //el poderoso
         case 5:
            return '#72ad4c'; 
         case 6:
            return '#6d579e'; 
        default:
            return '#0F0F0'; 
    }
}

foreach ($eventos as $evento) {
    $descripcion = "Estado: {$evento['estado']}
    \Iniciales: {$evento['iniciales']}
    \nPrioridad: {$evento['prioridad']}
    \nRIT: {$evento['rit']}
    \nAño: {$evento['era']}
    \nTipo de Trámite: {$evento['tipotramite']}
    \nTipo de Plazo: {$evento['tipoplazo']}
    \nNúmero de Días: {$evento['ndias']}
    \nFecha de Ingreso: {$evento['fehchaingreso']}
    \nFecha Fatal: {$evento['fechafatal']}
    \nid: {$evento['id']}
    \nobservacion: {$evento['observacion']}
    \nCC: {$evento['correocc']}
    \nCorreo: {$evento['id_unidad']}";

    $evento['fechafatal'] = date('Y-m-d', strtotime($evento['fechafatal'] . ' -0 day'));
    $evento['fehchaingreso'] = date('Y-m-d', strtotime($evento['fehchaingreso'] . ' +1 day'));


    $color = obtenerColorPorIdUnidad($evento['id_unidad']);
    $evento_calendario = [
        'title' => $evento['tipotramite'],
        'start' => $evento['fechafatal'],
        'end' => $evento['fechafatal'],
        'description' => $descripcion,
        'color' => obtenerColorPorIdUnidad($evento['id_unidad']),
    ];

    $eventos_calendario[] = $evento_calendario;
}

?>