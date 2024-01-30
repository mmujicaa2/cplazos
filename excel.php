<?php
//include "config.php";
include "conexion.php";

$fechainicial = isset($_POST['fechainicial']) ? $_POST['fechainicial'] : '';
$fechafinal = isset($_POST['fechafinal']) ? $_POST['fechafinal'] : '';
$fechainicial = !empty($fechainicial) ? date('d-m-Y', strtotime($fechainicial)) : '';
$fechafinal = !empty($fechafinal) ? date('d-m-Y', strtotime($fechafinal)) : '';
$estado=trim(strtoupper($_POST['estado']));

if (empty($fechainicial)) {
    $fechainicial = date("d-m-Y");
    $fechafinal = date("d-m-Y");
}
$sql = "SELECT rit AS RIT, fechafatal AS FECHA_PERENTORIA, iniciales AS RESPONSABLE, observacion AS OBSERVACION, estado AS estado
FROM agenda
WHERE estado = '$estado'
AND fechafatal BETWEEN STR_TO_DATE('$fechainicial','%d-%m-%Y') AND STR_TO_DATE('$fechafinal','%d-%m-%Y')
ORDER BY fechafatal ASC";


//mejorar sintaxis
$resultado = $pdo->query($sql);

$eventos = array();
while ($rows = $resultado->fetch(PDO::FETCH_ASSOC)) {
    $eventos[] = $rows;
}

if (!empty($eventos)) {
    $filename = "eventos.xls";
	//header("Content-Type: text/html; charset=utf-8");
    header("Content-Type: application/vnd.ms-excel; charset=latin-1");
    header("Content-Disposition: attachment; filename=" . $filename);

    $mostrar_columnas = false;

    foreach ($eventos as $evento) {
        if (!$mostrar_columnas) {
            echo implode("\t", array_keys($evento)) . "\n";
            $mostrar_columnas = true;
            //echo ('$mostrar_columnas');
        }
        echo implode("\t", array_values($evento)) . "\n";
    }
} else {
    echo 'No hay datos a exportar';
    echo($sql);
}
exit;
?>
