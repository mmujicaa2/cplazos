<?php require('config.php');
require('fetchEvents.php');
$date = date("Y/m/d");
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <title>Calendario</title>
    <meta charset='utf-8' />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment-with-locales.min.js" integrity="sha512-lQR9pLx+zmyQV/T99+vuBITpGAYXR+nMAZXVjtdEgnC3jodfmtjhRTuAnQ7jHjlWgUL0KE+SORFWdWEp1BYLFw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-business-days/1.2.0/index.js" integrity="sha512-SOgJ28iBwBLZWvQUbMVFcvdGOTCDVmaSshVd+e/o60PDJMQB1TcMSVV0sh2ZJqp2rmZt+I2ir+VMIPY8Ng172A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
               <script>
                $(document).ready(function() {
    $('#fechafatal').on('change', function() {
        var fechaIngreso = moment($('#fechaingreso').val());
        var nuevaFechaFatal = moment($(this).val());
        var diasHabiles = moment.duration(nuevaFechaFatal.businessDiff(fechaIngreso), 'days').asDays();
       
        $('#ndias').val(diasHabiles);
    });
});
               </script>
          <div class="modal-body">
          <form action="eventHandler.php" method="post">
    <label for="iniciales">Iniciales:</label>
    <input type="text" id="iniciales" name="iniciales" required><br><br>
    <label for="rit">RIT y AÑO:</label>
    <input type="text" id="rit" name="rit"  ><br><br>

    

    <label for="tipotramite">Tipo de Trámite:</label>
    <input type="text" id="tipotramite" name="tipotramite" required><br><br>

    <label for="tipoplazo">Tipo de Plazo:</label>
    <input type="text" id="tipoplazo" name="tipoplazo" required><br><br>

    <label for="fechafatal">Fecha Fatal:</label>
    <input type="date" id="fechafatal" name="fechafatal" required><br>
 <!--  <label for="rit">Cantidad de días (habiles):</label>
    <input type="text" id="ndias" name="ndias" readonly><br><br> -->
    <label for="id_unidad">Unidad:</label>
    <select name="id_unidad" id="id_unidad" required>
        <option value="">Seleccione</option>
        <?php
        $sqlunidad = "SELECT * FROM correounidad;";
        $stmt = $pdo->query($sqlunidad);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['id_unidad'] . "'>" . $row['correo'] . "</option>";
        }
        ?>
    </select><br><br>
    <label for="correocc">CC:</label>
    <input type="email" id="correocc" name="correocc" ><br><br>
    <hr>
    <label for="observacion">Observaciones:</label>
    <textarea id="observacion" name="observacion" rows="4" cols="50"></textarea>

    <input type="submit" value="Agregar Alerta">
</form>
    <input type="hidden" id="era" name="era" readonly required><br>
<script>
$(document).ready(function () {
    $('#enableEdit').change(function () {
        var enableEdit = $(this).prop('checked');
        $('#rit').prop('readonly', !enableEdit).val(enableEdit ? '' : '');
        $('#era').prop('readonly', !enableEdit).val(enableEdit ? '' : '');
    });
});
</script>
                </div>
                </div>
                </div>
                </div>
               <!-- modal descripcion-->
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
    <button class="btn btn-success" id="RecibidoButton" name="editarestado" required value="Recibido">Realizado</button>
    <button class="btn btn-warning" id="PendienteButton" name="editarestado" required value="Pendiente">Pendiente</button>
                </div>
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
                
                
                <label for="editariniciales">Iniciales:</label>
                <input type="text" id="editariniciales" name="editariniciales" required value="VALOR_ANTERIOR"><br><br>
            <!--    <label for="prioridad">Prioridad:</label>
                <select name="editarprioridad" id="editarprioridad"required value="VALOR_ANTERIOR" >
                <option value="1">Baja</option>
                <option value="2">Media</option>
                <option value="3">Alta</option>
                </select><br> -->
                <label for="enableEdit">Habilitar RIT y Año:</label>
                <input type="checkbox" id="enableEdit2" name="enableEdit2"><br>


                <label for="editarRit">RIT:</label>
                <input type="text" id="editarRit" name="editarRit" required value="VALOR_ANTERIOR">
                <label for="editarAno">AÑO:</label>
                <input type="text" id="editarAno" name="editarAno" required value="VALOR_ANTERIOR"><br><br> 


                                <script>
                $(document).ready(function () {
                    $('#enableEdit2').change(function () {
                        var enableEdit2 = $(this).prop('checked');
                        $('#editarRit').prop('readonly', !enableEdit2).val;
                        $('#editarAno').prop('readonly', !enableEdit2).val;
                    });
                });
                </script>

                <label for="editarTipoTramite">Tipo de tramite:</label>
                <input type="text" id="editarTipoTramite" name="editarTipoTramite" required value="VALOR_ANTERIOR"><br><br>
                <label for="editarTipoPlazo">Tipo de plazo:</label>
                <input type="text" id="editarTipoPlazo" name="editarTipoPlazo" required value="VALOR_ANTERIOR"><br><br>
          <!-- <label for="editarFechaIngreso">Fecha de ingreso:</label>
                <input type="text" id="editarFechaIngreso" name="editarFechaIngreso" required value="VALOR_ANTERIOR"><br><br> -->
                <label for="editarFechaFatal">Cambiar Fecha fatal:</label>
                <input type="hidden" id="Recibido" name="editarestado" required value="Recibido"> 
                <input type="hidden" id="Pendiente" name="editarestado" required value="Pendiente" checked>
                <input type="hidden" id="editarFechaFatal" name="editarFechaFatal" />
                <input type="hidden" id="mostrarFechaFatal" name="mostrarFechaFatal" readonly />
                <input type="date" id="campoFechaVisible" name="campoFechaVisible" />

    <script>
    function formatearFecha(fecha) {
        return moment(fecha, 'DD/MM/YYYY').format('YYYY-MM-DD');
    }
    document.getElementById('editarFechaFatal').value = "VALOR_ANTERIOR";
    var fechaFormateada = formatearFecha("VALOR_ANTERIOR");
    document.getElementById('mostrarFechaFatal').value = fechaFormateada;
    document.getElementById('campoFechaVisible').value = "VALOR_ANTERIOR";
    </script>
                <hr>
                <label for="observacion">Observaciones:</label>
                <textarea id="editarobservacion" name="editarobservacion" rows="4" cols="61" required value="VALOR_ANTERIOR"></textarea>
                <button type="button" class="btn btn-primary" id="guardarEdicion">Guardar Cambios</button>
                </div>
                </div>
                </div>
                </div>
                </div> 
                <input type="hidden" id="editarId" name="editarId" required value="VALOR_ANTERIOR" disabled><br><br>
 <!-- modal eliminar xao xaito -->
<div class="modal" id="confirmarEliminarModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar eliminación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar este evento?
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="eliminarEventoConfirmado">Eliminar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal feriado -->
<div class="modal fade" id="avisoFeriadoModal" tabindex="-1" role="dialog" aria-labelledby="avisoFeriadoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="avisoFeriadoModalLabel">¡Aviso de Feriado!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Esta fecha es un feriado.
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" id="correrDiaBtn">Sí, correr un día</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        
      </div>
    </div>
  </div>
</div>
<style>
.fc-event-title {
    color: #FFFFFF; /* Color del texto */
    font-size: 14px; /* Tamaño de la fuente */
    /* Otros estilos que desees aplicar */
}
</style>
    <div id='calendar'></div>
    <?php include('js.php') ?>
</body>
</html>