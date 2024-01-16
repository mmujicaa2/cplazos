<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        firstDay: 1,
        locale: 'es',
        initialView: 'dayGridMonth',
        height: 650,
        events: <?php echo json_encode($eventos_calendario); ?>,
        eventClick: function(info) {
            const idMatch = info.event.extendedProps.description.match(/id: (\d+)/);
            const ritMatch = info.event.extendedProps.description.match(/RIT: (\d+)/);
            const anoMatch = info.event.extendedProps.description.match(/Año: (\d+)/);
            const tipoTramiteMatch = info.event.extendedProps.description.match(/Tipo de Trámite: (\w+)/);
            const tipoPlazoMatch = info.event.extendedProps.description.match(/Tipo de Plazo: (\w+)/);
            const diasMatch = info.event.extendedProps.description.match(/Número de Días: (\d+)/);
            const fechaIngresoMatch = info.event.extendedProps.description.match(/Fecha de Ingreso: (\d{4}-\d{2}-\d{2})/);
            const fechaFatalMatch = info.event.extendedProps.description.match(/Fecha Fatal: (\d{4}-\d{2}-\d{2})/);
            
            var idValue = idMatch ? idMatch[1] : 'No disponible';
            var ritValue = ritMatch ? ritMatch[1] : 'No disponible';
            var anoValue = anoMatch ? anoMatch[1] : 'No disponible';
            var tipoTramiteValue = tipoTramiteMatch ? tipoTramiteMatch[1] : 'No disponible';
            var tipoPlazoValue = tipoPlazoMatch ? tipoPlazoMatch[1] : 'No disponible';
            var diasValue = diasMatch ? diasMatch[1] : 'No disponible';
            var fechaIngresoValue = fechaIngresoMatch ? fechaIngresoMatch[1] : 'No disponible';
            var fechaFatalValue = fechaFatalMatch ? fechaFatalMatch[1] : 'No disponible';

            if (fechaIngresoMatch && fechaIngresoMatch.length > 1) {
            const fechaIngreso = new Date(fechaIngresoMatch[1]);
            const fechaIngresoFormateada = fechaIngreso.toLocaleDateString('es-ES');
            fechaIngresoValue = fechaIngresoFormateada;
            }
            if (fechaFatalMatch && fechaFatalMatch.length > 1) {
            const fechaFatal = new Date(fechaFatalMatch[1]);
            const fechaFatalFormateada = fechaFatal.toLocaleDateString('es-ES');
            fechaFatalValue = fechaFatalFormateada; }
            
            var detalles = [
            //   { label: 'id', value: idValue },
                { label: 'RIT', value: ritValue },
                { label: 'Año', value: anoValue },
                { label: 'Tipo de Trámite', value: tipoTramiteValue },
                { label: 'Tipo de Plazo', value: tipoPlazoValue },
            //   { label: 'Número de Días', value: diasValue },
                { label: 'Fecha de Ingreso', value: fechaIngresoValue },
                { label: 'Fecha Fatal', value: fechaFatalValue }
            ];
            var html = '';
            detalles.forEach(function(detalle) {
                html += '<strong>' + detalle.label + ':</strong> ' + detalle.value + '<br>';
            });
            $('#eventoDetalles').html(html);
            $('#eventoModal').modal('show');

            eventoSeleccionado = {
                id: idValue,
                rit: ritValue,
                ano: anoValue,
                tipoTramite: tipoTramiteValue,
                tipoPlazo: tipoPlazoValue,
                fechaIngreso: fechaIngresoValue,
                fechaFatal: fechaFatalValue
                    };
        $(document).on('click', '#editarEvento', function() {
            if (eventoSeleccionado) {
                document.getElementById('editarId').value = eventoSeleccionado.id;
                document.getElementById('editarRit').value = eventoSeleccionado.rit;
                document.getElementById('editarAno').value = eventoSeleccionado.ano;
                document.getElementById('editarTipoTramite').value = eventoSeleccionado.tipoTramite;
                document.getElementById('editarTipoPlazo').value = eventoSeleccionado.tipoPlazo;
          //  document.getElementById('editarFechaIngreso').value = eventoSeleccionado.fechaIngreso;
                console.log("Fecha Fatal seleccionada:", eventoSeleccionado.fechaFatal);

                document.getElementById('editarFechaFatal').value = eventoSeleccionado.fechaFatal;
                document.getElementById('mostrarFecha').value = eventoSeleccionado.fechaFatal;
                $('#editarEventoModal').modal('show');
            } else {
                alert('Primero debes seleccionar un evento para editarlo.');
            }
        });

        $(document).on('click', '#eliminarEvento', function() {
                if (eventoSeleccionado && eventoSeleccionado.id !== 'No disponible') {
                    if (confirm("¿Estás seguro de que deseas eliminar este evento?")) {
                        eliminarEvento(eventoSeleccionado.id);
                    }
                } else {
                    alert('Primero debes seleccionar un evento para eliminarlo.');
                }
            });
        }
    });
    calendar.render();
});

function eliminarEvento(idEvento) {
    $.post('del.php', { id: idEvento }, function(response) {
        if (response.success) {
            alert('Evento eliminado con éxito.');
            location.reload(); // Actualiza la página para reflejar los cambios
        } else {
            alert('Error al eliminar el evento: ' + response.message);
        }
    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Error:", textStatus, errorThrown);
    });
}
</script>
    <script>
        function agregarEvento() {
            var rit = document.getElementById('rit').value;
            var era = document.getElementById('era').value;
            var tipotramite = document.getElementById('tipotramite').value;
            var tipoplazo = document.getElementById('tipoplazo').value;
            var ndias = document.getElementById('ndias').value;
            var fechafatal = document.getElementById('fechafatal').value;
            var correo = document.getElementById('correo').value;
            $.post('eventHandler.php', {
                rit: rit,
                era: era,
                tipotramite: tipotramite,
                tipoplazo: tipoplazo,
                ndias: ndias,
                fechafatal: fechafatal,
                correo: correo
            }, function(response) {
                if (response.success) {
                    alert('Evento agregado con éxito');
                    $('#agregarEventoModal').modal('hide');
                    location.reload(); 
                } else {
                    alert('Error al agregar el evento');
                }
            });
        }
    </script>
    <script>
    $(document).ready(function() {
        $('#guardarEdicion').click(function() {
            console.log("Botón guardadoEdicion clickeado");
       
            var id = $('#editarId').val();
            var rit = $('#editarRit').val();
            var ano = $('#editarAno').val();
            var tipoTramite = $('#editarTipoTramite').val();
            var tipoPlazo = $('#editarTipoPlazo').val();
            var fechaFatal = $('#editarFechaFatal').val();
            
            $.post('edit.php', {
                id: id, 
                rit: rit,
                ano: ano,
                tipoTramite: tipoTramite,
                tipoPlazo: tipoPlazo,
                fechaFatal: fechaFatal
            }, function(response) {
                console.log("Respuesta de edit.php:", response); 

                if (response.success) {
                    alert('Cambios guardados con éxito.');
                    $('#editarEventoModal').modal('hide');
                    location.reload(); 
                } else {
                    alert('Error al guardar los cambios: ' + response.message);
                }
            },'json').fail(function(jqXHR, textStatus, errorThrown) {
    console.log("Error:", textStatus, errorThrown);
});
        });
    });
</script>
   <!-- <script>
        document.addEventListener('DOMContentLoaded', function() { 
        const rangoDiasSelect = document.getElementById('rangoDias');
        const fechaFatalInput = document.getElementById('fechafatal');
        rangoDiasSelect.addEventListener('change', function() {
        const rangoSeleccionado = this.value;
        const diasDesdeHoy = parseInt(rangoSeleccionado.split('-')[1]); 
        const fechaFatal = new Date();
        fechaFatal.setDate(fechaFatal.getDate() + diasDesdeHoy);
        const dia = String(fechaFatal.getDate()).padStart(2, '0');
        const mes = String(fechaFatal.getMonth() + 1).padStart(2, '0'); 
        const anio = fechaFatal.getFullYear();
        const fechaFormateada = ${anio}-${mes}-${dia};
        fechaFatalInput.value = fechaFormateada;
    });
});
    </script> -->
    <script>
        function agregarEvento() {
            var rit = document.getElementById('rit').value;
            var era = document.getElementById('era').value;
            var tipotramite = document.getElementById('tipotramite').value;
            var tipoplazo = document.getElementById('tipoplazo').value;
            var ndias = document.getElementById('ndias').value;
            var fechafatal = document.getElementById('fechafatal').value;
            var correo = document.getElementById('correo').value;
            $.post('eventHandler.php', {
                rit: rit,
                era: era,
                tipotramite: tipotramite,
                tipoplazo: tipoplazo,
                ndias: ndias,
                fechafatal: fechafatal,
                correo: correo
            }, function(response) {
                if (response.success) {
                    alert('Evento agregado con éxito');
                    $('#agregarEventoModal').modal('hide');
                    location.reload(); 
                } else {
                    alert('Error al agregar el evento');
                }
            });
        }
    </script>
    <script>
    $(document).ready(function() {
        $('#guardarEdicion').click(function() {
            console.log("Botón guardadoEdicion clickeado");
       
            var id = $('#editarId').val();
            var rit = $('#editarRit').val();
            var ano = $('#editarAno').val();
            var tipoTramite = $('#editarTipoTramite').val();
            var tipoPlazo = $('#editarTipoPlazo').val();
            var fechaFatal = $('#editarFechaFatal').val();
            
            $.post('edit.php', {
                id: id, 
                rit: rit,
                ano: ano,
                tipoTramite: tipoTramite,
                tipoPlazo: tipoPlazo,
                fechaFatal: fechaFatal
            }, function(response) {
                console.log("Respuesta de edit.php:", response); 

                if (response.success) {
                    alert('Cambios guardados con éxito.');
                    $('#editarEventoModal').modal('hide');
                    location.reload(); 
                } else {
                    alert('Error al guardar los cambios: ' + response.message);
                }
            },'json').fail(function(jqXHR, textStatus, errorThrown) {
    console.log("Error:", textStatus, errorThrown);
});
        });
    });
</script>
<script>
$(document).ready(function() {

var selectedEventId; 
$('.editar').click(function() {
    selectedEventId = $(this).data('id'); 
});
$('#borrarEvento').click(function() {
    if (selectedEventId) { 
      
        if (confirm("¿Estás seguro de que deseas eliminar este evento?")) {
            $.post('del.php', { id: selectedEventId }, function(response) {
                if (response.success) {
                    alert('Evento eliminado con éxito.');
                    location.reload();  
                } else {
                    alert('Error al eliminar el evento: ' + response.message);
                }
            }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
                console.log("Error:", textStatus, errorThrown);
            });
        }
    } else {
        alert('Por favor, selecciona un evento primero.');
        console.log(selectedEventId);
    }
});
});
</script>
   <!-- <script>
        document.addEventListener('DOMContentLoaded', function() { 
        const rangoDiasSelect = document.getElementById('rangoDias');
        const fechaFatalInput = document.getElementById('fechafatal');
        rangoDiasSelect.addEventListener('change', function() {
        const rangoSeleccionado = this.value;
        const diasDesdeHoy = parseInt(rangoSeleccionado.split('-')[1]); 
        const fechaFatal = new Date();
        fechaFatal.setDate(fechaFatal.getDate() + diasDesdeHoy);
        const dia = String(fechaFatal.getDate()).padStart(2, '0');
        const mes = String(fechaFatal.getMonth() + 1).padStart(2, '0'); 
        const anio = fechaFatal.getFullYear();
        const fechaFormateada = `${anio}-${mes}-${dia}`;
        fechaFatalInput.value = fechaFormateada;
    });
});
    </script> -->
