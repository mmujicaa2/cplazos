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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment-with-locales.min.js" integrity="sha512-4F1cxYdMiAW98oomSLaygEwmCnIP38pb4Kx70yQYqRwLVCs3DbRumfBq82T08g/4LJ/smbFGFpmeFlQgoDccgg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-business-days/1.2.0/index.js" integrity="sha512-SOgJ28iBwBLZWvQUbMVFcvdGOTCDVmaSshVd+e/o60PDJMQB1TcMSVV0sh2ZJqp2rmZt+I2ir+VMIPY8Ng172A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
  </head>
    <body>
      <br>
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
    <label for="iniciales">Iniciales:</label><br>
    <input type="text" id="iniciales" name="iniciales" required><br>
    <label for="rit">RIT y AÑO:</label><br>
    <input type="text" id="rit" name="rit" placeholder="Opcional" ><br>

    <label for="tipotramite">Tipo de Trámite:</label><br>
    <input type="text" id="tipotramite" name="tipotramite" required ><br>

    <label for="fechafatal">Fecha Fatal:</label><br>
    <input type="date" id="fechafatal" name="fechafatal" required><br>
 <!--  <label for="rit">Cantidad de días (habiles):</label>
    <input type="text" id="ndias" name="ndias" readonly><br><br> -->
    <label for="id_unidad">Unidad:</label><br>
    <select name="id_unidad" id="id_unidad" required>
        <option value="">Seleccione</option>
        <?php
            $sqlunidad = "SELECT * FROM unidad order by nunidad;";
            $stmt = $pdo->query($sqlunidad);
           while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            echo "<option value='" . $row['id_unidad'] . "'>" . $row['nunidad'] . "</option>";
            }
        ?>

        
    </select><br>
    <label for="correocc">CC:</label>
    <br>
    <input type="email" id="correocc" name="correocc"  placeholder="Opcional" style="width : 60%" ><br>
    
    <label for="observacion">Observaciones:</label>
    <textarea id="observacion" name="observacion" rows="5" cols="60"  placeholder="Opcional"></textarea>
<br>
<hr>
    <input type="submit" class="btn btn-primary" value="Agregar Alerta">
</form>
   
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
    <button class="btn btn-success" id="RecibidoButton" name="editarestado" required value="Realizado">Realizado</button>
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
                <label for="editariniciales">Iniciales:</label><br>
                <input type="text" id="editariniciales" name="editariniciales" required value="VALOR_ANTERIOR"><br><br>
            <!--    <label for="prioridad">Prioridad:</label>
                <select name="editarprioridad" id="editarprioridad"required value="VALOR_ANTERIOR" >
                <option value="1">Baja</option>
                <option value="2">Media</option>
                <option value="3">Alta</option>
                </select><br> -->
               
                <label for="editarRit">Rit y Año:</label><br>
                <input type="text" id="editarRit" name="editarRit" required value="VALOR_ANTERIOR">
                <input type="hidden" id="editarAno" name="editarAno" required value="VALOR_ANTERIOR">
            <br>
              

                <label for="editarTipoTramite">Tipo de tramite:</label><br>
                <input type="text" id="editarTipoTramite" name="editarTipoTramite" required value="VALOR_ANTERIOR"><br>
                
               
          <!-- <label for="editarFechaIngreso">Fecha de ingreso:</label>
                <input type="text" id="editarFechaIngreso" name="editarFechaIngreso" required value="VALOR_ANTERIOR"><br><br> -->
                <label for="editarFechaFatal">Cambiar Fecha fatal:</label><br>
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
                <input type="hidden" id="editarTipoPlazo" name="editarTipoPlazo" required value="VALOR_ANTERIOR">
                <input type="hidden" id="editarId" name="editarId" required value="VALOR_ANTERIOR" disabled>
                <input type="hidden" id="id_unidad" name="id_unidad" required value="VALOR_ANTERIOR" disabled>
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
     
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Exportar eventos a Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                                <!-- Form excel -->
                                <form id="exportForm" action="excel.php" method="post">
    <label for="fechainicial">Fecha Inicial:</label><br>
    <input type="date" id="fechainicial" name="fechainicial" required><br>
    <br>
    <label for="fechafinal">Fecha Final:</label><br>
    <input type="date" id="fechafinal" name="fechafinal" required><br><br>
    <label for="tipotramite">Estado:</label><br>
    <select name="estado" id="estado" required><br>
        <option value="">Seleccione</option>
        <?php
        $sqlTipotramite = "SELECT DISTINCT estado FROM agenda;";
        $stmtTipotramite = $pdo->query($sqlTipotramite);
        while ($rowTipotramite = $stmtTipotramite->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $rowTipotramite['estado'] . "'>" . $rowTipotramite['estado'] . "</option>";
        }
        ?>
    </select>
    <br>
    <br>
    <hr>
    <button type="submit" class="btn btn-success">Exportar a Excel</button>
</form>
            </div>
        </div>
    </div>
</div>
<!-- actualizar -->
<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="miModalLabel">Mensaje de Actualización</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="modalMensaje">¡Actualización exitosa!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<style>
.fc-event-title {
    color: #FFFFFF; 
    font-size: 14px; 
}
</style>
    <div id='calendar'></div>
    <?php include('js.php') ?>
</body>
<style>
.fc .fc-button-primary {
    background-color: #007fff;
    border-color: #ffffff;
    color: var(--fc-button-text-color);
}
  </style>
</html>