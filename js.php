<script>document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {

        customButtons: {
            custom1: {
                text: 'Nueva Alerta',
                click: function() {
                    $('#agregarEventoModal').modal('show');
                }
            },
            custom2: {
                text: 'Excel',
                click: function() {
                    $('#exportModal').modal('show');
                }
            },
            custom3: {
                text: 'Cambiar vista',
                click: function() {
                    // Obtener la vista actual
                    var currentView = calendar.view.type;
                    
                    // Cambiar a la vista opuesta
                    var newView = (currentView === 'multiMonthYear') ? 'dayGridMonth' : 'multiMonthYear';
                    calendar.changeView(newView); 
                }
            }
        },
        headerToolbar: {
            right: 'prev,custom3,next today',
            center: 'title',
            left: 'custom1,custom2'  
        },
        eventDidMount: function(info) {
//  tooltips
var clonedEvent = info.event.toPlainObject();
//  día 
clonedEvent.start = moment(info.event.start).add(0, 'days');
clonedEvent.end = moment(info.event.end).add(0, 'days');
info.event.setExtendedProp('extendedProps', clonedEvent.extendedProps);
info.event.setDates(clonedEvent.start, clonedEvent.end);
            const estadoMatch = info.event.extendedProps.description.match(/Estado:\s*(\w+)/i);
            const inicialesMatch = info.event.extendedProps.description.match(/Iniciales:\s*(\w+)/i);
            const tipoTramiteMatch = info.event.extendedProps.description.match(/Tipo de Trámite: (\w+)/);
            var estadoValue = estadoMatch ? estadoMatch[1] : 'No disponible';
            var inicialesValue = inicialesMatch ? inicialesMatch[1] : 'No disponible';
            var tipoTramiteValue = tipoTramiteMatch ? tipoTramiteMatch[1] : 'No disponible';
        var tooltip = new bootstrap.Tooltip(info.el, {
        title: 'Iniciales: ' + inicialesValue +
               '<br>Estado: ' + estadoValue +
               '<br>Trámite: ' + tipoTramiteValue,
        placement: 'top',
        container: 'body',
        html: true        
      });
      if (estadoValue === 'Realizado') {
    var checkIcon = document.createElement('i');
    checkIcon.className = 'fa-regular fa-circle-check fa-xl';

   
    var titleContainer = info.el.querySelector(".fc-event-title-container");
    titleContainer.insertBefore(checkIcon, titleContainer.firstChild);
}
    },
        timeZone: 'UTC',
        eventColor: '#0080FF',
        // FF0000 red
        // 00FF0F verde
        // FFFF00 yellow
        firstDay: 1, //para q el dia empiece en lunes
        locale: 'es', //idioma  
        initialView: 'dayGridMonth',
        height: 650,
        events: 
        <?php echo json_encode($eventos_calendario); ?>, //recorre fetchevents
            // para ver la descripcion en los modal
        eventClick: function(info) {
            const estadoMatch = info.event.extendedProps.description.match(/Estado:\s*(\w+)/i);
            const inicialesMatch = info.event.extendedProps.description.match(/Iniciales:\s*(\w+)/i);
         // const prioridadMatch = info.event.extendedProps.description.match(/Prioridad:\s*(\d+)/i);
            const idMatch = info.event.extendedProps.description.match(/id: (\d+)/);
            const id_unidadMatch = info.event.extendedProps.description.match(/Correo:\s*([^\n]+)/);

            const ritMatch = info.event.extendedProps.description.match(/RIT:\s*([^\n]+)/);
            const anoMatch = info.event.extendedProps.description.match(/Año: (\d+)/);
            const tipoTramiteMatch = info.event.extendedProps.description.match(/Tipo de Trámite:\s*([^\n]+)/);
            const tipoPlazoMatch = info.event.extendedProps.description.match(/Tipo de Plazo: (\w+)/);
            const diasMatch = info.event.extendedProps.description.match(/Número de Días: (\d+)/);
            const fechaIngresoMatch = info.event.extendedProps.description.match(/Fecha de Ingreso: (\d{4}-\d{2}-\d{2})/);
            const fechaFatalMatch = info.event.extendedProps.description.match(/Fecha Fatal: (\d{4}-\d{2}-\d{2})/);
            const observacionMatch = info.event.extendedProps.description.match(/observacion:\s*([^\n]+)/);
            var observacionValue = observacionMatch ? observacionMatch[1] : 'No disponible';
            const observacionLimpia = observacionValue.replace(/\s*CC:\s*\S+\s*Correo:\s*\S+\s*/i, '');

            const correoccMatch = info.event.extendedProps.description.match(/CC:\s*([^\n]+)/);

            var estadoValue = estadoMatch ? estadoMatch[1] : 'No disponible';
            var inicialesValue = inicialesMatch ? inicialesMatch[1] : 'No disponible';
       //   var prioridadValue = prioridadMatch ? prioridadMatch[1] : 'No disponible';
            var idValue = idMatch ? idMatch[1] : 'No disponible';
            var id_unidadValue = id_unidadMatch ? id_unidadMatch[1].trim() : 'No disponible';
            var ritValue = ritMatch ? ritMatch[1] : 'Sin detalles';
            var anoValue = anoMatch ? anoMatch[1] : 'Sin detalles';
            const tipoTramiteValue = tipoTramiteMatch ? tipoTramiteMatch[1].trim() : 'No disponible';
            var tipoPlazoValue = tipoPlazoMatch ? tipoPlazoMatch[1] : 'No disponible';
            var diasValue = diasMatch ? diasMatch[1] : 'No disponible';
            var fechaIngresoValue = fechaIngresoMatch ? fechaIngresoMatch[1] : 'No disponible';
            var fechaFatalValue = fechaFatalMatch ? fechaFatalMatch[1] : 'No disponible';
            var observacionValue = observacionMatch ? observacionMatch[1] : 'No disponible';
            var correoccValue = correoccMatch ? (correoccMatch[1].trim() === 'Correo: 2' ? 'No disponible' : correoccMatch[1].trim()) : 'No disponible';
            var correoccValue = correoccMatch ? (correoccMatch[1].trim() === 'Correo: 4' ? 'No disponible' : correoccMatch[1].trim()) : 'No disponible';
            
                    //formato para fecha 
            if (fechaIngresoMatch && fechaIngresoMatch.length > 1) {
                const fechaIngreso = moment(fechaIngresoMatch[1]);
                const fechaIngresoFormateada = fechaIngreso.format('DD/MM/YYYY');  
                fechaIngresoValue = fechaIngresoFormateada;
            }
            if (fechaFatalMatch && fechaFatalMatch.length > 1) {
                const fechaFatal = moment(fechaFatalMatch[1]);
                const fechaFatalFormateada = fechaFatal.format('DD/MM/YYYY');  
                fechaFatalValue = fechaFatalFormateada;
            }
            var detalles = [
    // { label: 'id', value: idValue },
    { label: 'Estado', value: estadoValue },
    { label: 'iniciales', value: inicialesValue },
    // { label: 'prioridad', value: prioridadValue },
    { label: 'Rit y Año', value: (ritValue && ritValue !== '0') ? ritValue : 'Sin detalles' },
    //{ label: 'Año', value: (anoValue && anoValue !== '0000') ? anoValue : 'Sin detalles' },
    { label: 'Tipo de Trámite', value: tipoTramiteValue },
    // { label: 'Tipo de Plazo', value: tipoPlazoValue },
    // { label: 'Número de Días', value: diasValue },
    { label: 'Fecha de Ingreso', value: fechaIngresoValue },
    // { label: 'Fecha Fatal', value: fechaFatalValue },
    { label: 'CC', value: correoccValue },
    { label: 'Unidad', value: obtenerNombreUnidad(id_unidadValue) },
    { label: 'Observación', value: observacionLimpia }
];

function obtenerNombreUnidad(idUnidad) {
    // Puedes ajustar esto según tus necesidades
    switch (idUnidad) {
        case '1':
            return 'Unidad de Atencion de Público y Sala';
        case '2':
            return 'Unidad de Servicios y Cumplimiento';
        case '3':
            return 'Unidad de Causa';
        case '4':
            return 'test';
        case '5':
            return 'Jefaturas';
        case '6':
            return 'Notificaciones';
        default:
            return 'Desconocido';
    }
}
            var html = '';
                detalles.forEach(function(detalle) {
                html += '<strong>' + detalle.label + ':</strong> ' + detalle.value + '<br>';
            });
            $('#eventoDetalles').html(html);
            $('#eventoModal').modal('show');
            eventoSeleccionado = {
                estado: estadoValue,
                iniciales: inicialesValue,
          //    prioridad: prioridadValue,
                id: idValue,
                rit: ritValue,
                ano: anoValue,
                tipoTramite: tipoTramiteValue,
                tipoPlazo: tipoPlazoValue,
                fechaIngreso: fechaIngresoValue,
                fechaFatal: fechaFatalValue, 
                observacion: observacionValue,
                id_unidad: id_unidadValue
                
                    };
                    var estadoValue;
if (estadoValue === "Recibido") {
    $("#RecibidoButton").hide();
    $("#PendienteButton").show();
} else {
    $("#RecibidoButton").show();
    $("#PendienteButton").hide();
}
var estadoValue; 
$(document).ready(function() {
    $('#RecibidoButton, #PendienteButton').click(function() {
        estadoValue = $(this).val();
        console.log('Nuevo estado seleccionado:', estadoValue);
        guardarEstadoEnBaseDeDatos(estadoValue);
    });
});
function guardarEstadoEnBaseDeDatos(nuevoEstado) {
    var idEvento = eventoSeleccionado.id; 
    $.post('estado.php', {
    id: idEvento,
    nuevoEstado: nuevoEstado
}, function(response) {
    if (response.success) {
        alert('Estado actualizado.');
            location.reload(); 
    } else {
        console.error('Error al guardar el estado en la base de datos:', response.message);
    }
}, 'json').fail(function(jqXHR, textStatus, errorThrown) {
    console.log("Error:", textStatus, errorThrown);
    console.error(jqXHR.responseText); 
});
}
$(document).on('change', 'input[name="editarestado"]', function() {
    estadoValue = $(this).val();
    console.log('Nuevo estado seleccionado:', estadoValue);
});
$(document).on('click', '#editarEvento', function() {
    if (eventoSeleccionado) {
        console.log('Estado Value:', eventoSeleccionado.estado);
        $('input[name="editarestado"]').prop('checked', false); 
        $('input[name="editarestado"][value="' + eventoSeleccionado.estado + '"]').prop('checked', true);
        document.getElementById('editariniciales').value = eventoSeleccionado.iniciales;
     //   document.getElementById('editarprioridad').value = eventoSeleccionado.prioridad;
        document.getElementById('editarId').value = eventoSeleccionado.id;
        document.getElementById('editarRit').value = eventoSeleccionado.rit;
        document.getElementById('editarAno').value = eventoSeleccionado.ano;
        document.getElementById('editarTipoTramite').value = eventoSeleccionado.tipoTramite;
        document.getElementById('editarTipoPlazo').value = eventoSeleccionado.tipoPlazo;
        document.getElementById('id_unidad').value = eventoSeleccionado.id_unidad;

      if (eventoSeleccionado.fechaFatal && eventoSeleccionado.fechaFatal !== 'No disponible') {
        var editarFechaFatalInput = document.getElementById('editarFechaFatal');
        var fechaFormateada = formatearFecha(eventoSeleccionado.fechaFatal);

        editarFechaFatalInput.value = fechaFormateada;
        document.getElementById('campoFechaVisible').value = fechaFormateada;
    } else {
        document.getElementById('editarFechaFatal').value = '';
        document.getElementById('campoFechaVisible').value = '';
    }
        document.getElementById('editarobservacion').value = eventoSeleccionado.observacion;
        $('#editarEventoModal').modal('show');
    } else {
        alert('Primero debes seleccionar un evento para editarlo.');
    }
});
        $(document).on('click', '#eliminarEvento', function() {
    if (eventoSeleccionado && eventoSeleccionado.id !== 'No disponible') {
        $('#confirmarEliminarModal').modal('show');
    } else {
        alert('Primero debes seleccionar un evento para eliminarlo.');
    }
});
$(document).on('click', '#eliminarEventoConfirmado', function() {
    eliminarEvento(eventoSeleccionado.id);
    $('#confirmarEliminarModal').modal('hide');
});
        }     
    });
    calendar.render();
});function eliminarEvento(idEvento, id_unidad, rit, era, tipotramite, fechafatal, iniciales) {
    $.post('del.php', {
        id: idEvento,
        id_unidad: id_unidad,
        rit: rit,
        era: era,
        tipotramite: tipotramite,
        fechafatal: fechafatal,
        iniciales: iniciales
    }, function(response) {
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
</script>
<script>
    function agregarEvento() {
        var iniciales = document.getElementById('iniciales').value;
        var prioridadElement = document.getElementById('prioridad');
  //      var prioridad = prioridadElement.options[prioridadElement.selectedIndex].value;
        var rit = document.getElementById('rit').value;
        var era = document.getElementById('era').value;
        var tipotramite = document.getElementById('tipotramite').value;
        var tipoplazo = document.getElementById('tipoplazo').value;
        var ndias = document.getElementById('ndias').value;
        var fechafatal = document.getElementById('fechafatal').value;
        var correo = document.getElementById('correo').value;
        var observacion = document.getElementById('observacion').value;
        var correocc = document.getElementById('correocc').value;
        $.post('eventHandler.php', {
            iniciales: iniciales,
   //         prioridad: prioridad,
            rit: rit,
            era: era,
            tipotramite: tipotramite,
            tipoplazo: tipoplazo,
            ndias: ndias,
            fechafatal: fechafatal,
            correo: correo,
            observacion: observacion,
            correocc: correocc
        }, function(response) {
            if (response.success) {
                alert('Evento agregado con éxito');
                console.log("fecha :", fechafatal);
                $('#agregarEventoModal').modal('hide');
                location.reload();
            } else {
                alert('Error al agregar el evento');
            }
        });
    }
</script><script>
$(document).on('change', '#campoFechaVisible', function() {
    var nuevaFecha = $('#campoFechaVisible').val();
    $('#editarFechaFatal').val(nuevaFecha);
    console.log('Fecha Fatal actualizada:', nuevaFecha);
 
});
$(document).ready(function() {
    $('#guardarEdicion').click(function() {
        console.log("Botón guardadoEdicion clickeado");
        var estadoValue = $('input[name="editarestado"]:checked').val();
        if (!estadoValue) { 
            estadoValue = eventoSeleccionado.estado;
        }
        console.log("Estado Value antes de enviar:", estadoValue);
        var iniciales = $('#editariniciales').val();
        // var prioridad = $('#editarprioridad').val();
        var id = $('#editarId').val();
        var rit = $('#editarRit').val();
        var ano = $('#editarAno').val();
        var tipoTramite = $('#editarTipoTramite').val();
        var tipoPlazo = $('#editarTipoPlazo').val();
        var fechaInput = $('#editarFechaFatal').val();
        var id_unidad = $('#id_unidad').val();
console.log('Fecha Fatal original:', fechaInput);

if (!moment(fechaInput, 'YYYY-MM-DD').isValid()) {
    console.error('Fecha ingresada no válida:', fechaInput);
    alert('La fecha ingresada no es válida.');
    return;
}

var fechaFatal = moment(fechaInput, 'YYYY-MM-DD').format('YYYY-MM-DD');
console.log('Fecha Fatal actualizada:', fechaFatal);

        var observacion = $('#editarobservacion').val();
       $.post('edit.php', {
    estado: estadoValue,
    iniciales: iniciales,
    id: id,
    rit: rit,
    ano: ano,
    tipoTramite: tipoTramite,
    tipoPlazo: tipoPlazo,
    fechaFatal: fechaFatal,
    id_unidad: id_unidad,
    observacion: observacion 
}, function(response) {
            try {
                if (response && response.success) {
                    console.log('Éxito:', response.message);
                    console.log('Resultado de la actualización:', response.resultUpdate);
                    console.log('ID de la unidad:', response.unidad);

                    if (confirm('¡Actualización exitosa! ' + response.message)) {
                        location.reload();
                    }
                } else {
                    console.error('Error:', response.message);
                    $('#modalMensaje').text('Error: ' + response.message);
                    $('#miModal').modal('show');
                }
            } catch (error) {
                console.error('Error al procesar la respuesta:', error);
                $('#modalMensaje').text('Error al procesar la respuesta: ' + error);
                $('#miModal').modal('show');
            }
        }, 'json')
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Error:", textStatus, errorThrown);
            console.error(jqXHR.responseText); 
            // Muestra el mensaje de error del servidor en la consola
        });
    });
});
$(document).ready(function() {
    function esFeriado(fecha, callback) {
        fetch('feriado.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ fecha: fecha }),
        })
        .then(response => response.json())
        .then(data => callback(data.esFeriado))
        .catch(error => {
            console.error('Error al verificar el feriado', error);
            callback(false);
        });
    }
    function mostrarAlertaFeriado(fecha) {
        if (confirm('La fecha seleccionada es un feriado.')) {
           
        }
    }
    $('#fechafatal').on('change', function() {
        var nuevaFecha = $(this).val();
        esFeriado(nuevaFecha, function(esFeriado) {
            if (esFeriado) {
                mostrarAlertaFeriado(nuevaFecha);
            }
        });
    });
});

</script>