<?php require('config.php');
require('fetchEvents.php');
$date = date("Y/m/d");
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
    </head>
    <body>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarEventoModal">  Nueva Alerta </button>
    <div class="modal fade" id="agregarEventoModal" tabindex="-1" role="dialog" aria-labelledby="agregarEventoModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="agregarEventoModalLabel">Ingresar Alerta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
               <!-- modal agregar -->
          <div class="modal-body">
        <form action="eventHandler.php" method="post">
        <label for="rit">RIT:</label>
        <input type="text" id="rit" name="rit" required><br><br>
        <label for="era">Año:</label>
        <input type="text" id="era" name="era" required><br><br>
        <label for="tipotramite">Tipo de Trámite:</label>
        <input type="text" id="tipotramite" name="tipotramite" required><br><br>
        <label for="tipoplazo">Tipo de Plazo:</label>
        <input type="text" id="tipoplazo" name="tipoplazo" required><br><br>
        <label for="fechafatal">Fecha Fatal:</label>
        <input type="date" id="fechafatal" name="fechafatal" required><br><br>
        <label for="id_unidad">Unidad:</label>
        <select name="id_unidad" id="id_unidad" required>
        <option value="">Seleccione</option>
        <?php
        $sqlunidad = "SELECT * FROM correounidad;";
        $stmt = $pdo->query($sqlunidad);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='".$row['id_unidad']."'>".$row['correo']."</option>"; } ?>
        </select> <br><br> <hr>
        <input type="submit" value="Agregar Alerta ">
            </form>
                </div>
                </div>
            </div>
            </div>
               <!-- modal descripcion -->
        <div class="modal fade" id="eventoModal" tabindex="-1" role="dialog" aria-labelledby="eventoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventoModalLabel">Detalles del Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="eventoDetalles"></div><hr>
                <div class="mt-3">
        <button class="btn btn-primary ml-2" id="editarEvento">Editar</button>
        <button class="btn btn-danger" id="eliminarEvento">Eliminar</button>

    </div>
            </div>
            </div>
        </div>
        </div>
        <!-- modal editar -->
<div class="modal fade" id="editarEventoModal" tabindex="-1" role="dialog" aria-labelledby="editarEventoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarEventoModalLabel">Editar Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editarId" name="editarId" required value="VALOR_ANTERIOR" disabled><br><br>
                <label for="editarRit">RIT:</label>
                <input type="text" id="editarRit" name="editarRit" required value="VALOR_ANTERIOR"><br><br>
                <label for="editarAno">AÑO:</label>
                <input type="text" id="editarAno" name="editarAno" required value="VALOR_ANTERIOR"><br><br>
                <label for="editarTipoTramite">Tipo de tramite:</label>
                <input type="text" id="editarTipoTramite" name="editarTipoTramite" required value="VALOR_ANTERIOR"><br><br>
                <label for="editarTipoPlazo">Tipo de plazo:</label>
                <input type="text" id="editarTipoPlazo" name="editarTipoPlazo" required value="VALOR_ANTERIOR"><br><br>
          <!-- <label for="editarFechaIngreso">Fecha de ingreso:</label>
                <input type="text" id="editarFechaIngreso" name="editarFechaIngreso" required value="VALOR_ANTERIOR"><br><br> -->
                <label for="mostrarFecha">Fecha fatal:</label>
                <input type="text" id="mostrarFecha" name="mostrarFecha" required value="VALOR_ANTERIOR" disabled><br>
                <label for="editarFechaFatal">Cambiar Fecha fatal:</label>
                <input type="date" id="editarFechaFatal" name="editarFechaFatal" required value="VALOR_ANTERIOR">
                <hr>
                <button type="button" class="btn btn-primary" id="guardarEdicion">Guardar Cambios</button>
            </div>
            </div>
        </div>
    </div>
</div> 
    <div id='calendar'></div>
    <?php include('js.php') ?>
</body>
</html>