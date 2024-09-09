
function init(){
    $('#btnGuardar').on('click', function(e) {
        e.preventDefault();
        
        // Inicializar Parsley para el formulario
        var $formStep1 = $('#titulos_form').parsley();
        var isTitulosValid = $formStep1.validate();
        // Validar el formulario
        if (isTitulosValid) {
            guardaryeditar(e);
        } else {
            
            $formStep1.validationResult.errors.forEach(error => {
                $(error.element).focus();
            });
        }
    });
    $("#btnGuardarPDF").on("click", function(e) {
        e.preventDefault();
        
        var $formPDF = $('#adjuntar_form').parsley();
        
        // Validar el formulario
        var isValid = $formPDF.validate();

        if (isValid) {
            guardaryeditarimg(e);
        } else {
            // Si hay errores, asegúrate de mostrarlos
            $formPDF.$element.find('.parsley-error').each(function() {
                $(this).addClass('parsley-error');
            });
        }
    });
    $('#btnGuardarRecibo').on('click', function(e) {
        e.preventDefault();
        
        var $formPDF = $('#titulos_completar_form').parsley();
        
        // Validar el formulario
        var isValid = $formPDF.validate();

        if (isValid) {
            guardar_recibo(e);
        } else {
            // Si hay errores, asegúrate de mostrarlos
            $formPDF.$element.find('.parsley-error').each(function() {
                $(this).addClass('parsley-error');
            });
        }
        
    });
} 


function guardaryeditar(e) {
    e.preventDefault();
    
    
    const titulosForm = $('#titulos_form').serializeArray();

    
    if (!titulosForm) {
        console.error('Formulario de titulos no encontrado');
        return;
    }

    const formDataCombined = {};
    
    titulosForm.forEach(field => {
        formDataCombined[field.name] = field.value;
    });

    // Mostrar mensaje de confirmación antes de enviar el formulario
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Deseas guardar los cambios?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, enviar el formulario
            var formData = new FormData($("#titulos_form")[0]);

            $.ajax({
                url: "../../controller/titulo.php?op=guardaryeditar",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    // Cambiar el estado después de guardar
                    $.ajax({
                        url: "../../controller/certificado.php?op=cambiar_esttitulado",
                        type: "POST",
                        data: { cert_id: formData.get('cert_id') }, 
                        success: function(data) {
                            // Recargar la tabla
                            $('#titulos_data').DataTable().ajax.reload(function () {
                                // Una vez recargada la tabla, actualizar los totales
                                total_titulos_registrados();
                                total_titulos_pendientes();
                                total_titulos_completados();
                            });

                            // Mostrar mensaje de éxito con opciones
                            Swal.fire({
                                title: 'Correcto!',
                                text: 'Se Registró Correctamente',
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Volver a Certificados',
                                cancelButtonText: 'Imprimir',
                                cancelButtonColor: '#3085d6',
                                cancelButtonAriaLabel: 'Imprimir',
                                showCloseButton: true,
                                customClass: {
                                    closeButton: 'swal2-volver-certificado-button'
                                }
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.cancel) {
                                    // Acción de imprimir
                                    generar(formData.get('titu_id')); // Asegúrate de que titu_id esté definido
                                } else if (result.isConfirmed) {
                                    // Redireccionar a usucertificado
                                    window.location.href = '../UsuCertificado';
                                }
                            });
                        },
                        error: function(error) {
                            console.log("Error al cambiar el estado:", error);
                        }
                    });

                    // Ocultar el modal
                    $('#modalmantenimiento').modal('hide');
                },
                error: function(error) {
                    console.log("Error al guardar los datos:", error);
                }
            });
        }
    });
}
function guardar_recibo(e){
    e.preventDefault();
    
    
    var formData = new FormData($("#titulos_completar_form")[0]);
   
    Swal.fire({
        title: '¿Está seguro?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Acción cuando el usuario hace clic en Aceptar
            $.ajax({
                url: "../../controller/titulo.php?op=guardar_recibo", // ajusta la URL según sea necesario
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    var titu_id = $('#titu_id_completar').val();
                    console.log(titu_id)
                    $.post("../../controller/titulo.php?op=cambiar_estrecibo",{titu_id : titu_id}, function (response) {
                    $('#titulos_data').DataTable().ajax.reload(); // Recargar los datos en la tabla
                    
                    Swal.fire({
                        title: 'Correcto!',
                        text: 'Se registró correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al guardar el recibo.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
                
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Acción cuando el usuario hace clic en Cancelar
            Swal.fire('Cancelado');
        }
    });


$('#modalmantenimientocompletar').modal('hide');
}

$(document).ready(function(){
    'use strict';

    $('#wizard4').steps({
        headerTag: 'h3',
        bodyTag: 'section',
        autoFocus: true,
        titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
        onStepChanging: function (event, currentIndex, newIndex) {
            var $formStep1 = $('#titulos_form');
            $formStep1.parsley(); // Inicializa Parsley para el formulario
            return $formStep1.parsley().validate();
        },
        onFinishing: function (event, currentIndex) {
            var $formStep1 = $('#titulos_form');
            $formStep1.parsley(); // Inicializa Parsley para el formulario
            return $formStep1.parsley().validate();
        }
    });
});

$(document).ready(function(){
    combo_fecha_titulo();
    combo_completo_titulo();
    
    total_titulos_registrados();
    total_titulos_pendientes();
    total_titulos_completados();

$('#titulos_data').DataTable({
    "aProcessing": true,
    "aServerSide": true,
    dom: 'Bfrtip',
    buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
    ],
    "ajax": {
          "url": "../../controller/titulo.php?op=mostrar_titulo_propietario",
          "type": "POST",
          "data": function (d) {
            d.fecha = $('#combo_fecha_titulo').val();
            d.completo = $('#combo_completo_titulo').val();
            
          },
          "error": function(xhr, status, error) {
            console.error('Error al cargar los datos:', status, error);
          }
        },
    "bDestroy": true,
    "responsive": false,
    "bInfo":true,
    "iDisplayLength": 5,
    "order": [[ 0, "desc" ]],
    "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    },
    "createdRow": function(row, data, dataIndex) {
    console.log(data); // Añadir esto para depurar
    if (data.DT_RowClass) {
        $(row).addClass(data.DT_RowClass);
        $(row).css('background-color', '#d4edda'); // Estilo inline para verificar
    }
}
});

});



$(document).ready(function() {
    // Verificar si hay un parámetro cert_id en la URL
    const certId = localStorage.getItem('cert_id');

    if (cert_id) {
        titulacion(certId);

        // Eliminar el cert_id del localStorage después de usarlo
        localStorage.removeItem('cert_id');
    }

});

$('#combo_fecha_titulo, #combo_completo_titulo').change(function() {
    $('#titulos_data').DataTable().ajax.reload();
});

function titulacion(cert_id) {
    // Realizar la solicitud AJAX para obtener los detalles del propietario
    $.post("../../controller/certificado.php?op=mostrar_certificado_detalle", { cert_id: cert_id }, function (data) {
        data = JSON.parse(data);
        let propietarioInfo = '';
        // Iterar sobre cada elemento en data
        data.forEach(function(propietario, index) {
            propietarioInfo += `<p>Propietario ${index + 1}: ${propietario.prop_nombre} ${propietario.prop_apep} ${propietario.prop_apem}</p>
                                <p>DNI: ${propietario.prop_dni}</p>`;
        });

        // Mostrar el mensaje Swal con los datos del propietario y la lista de documentos
        Swal.fire({
            icon: 'info',
            title: 'Tener en cuenta',
            html: propietarioInfo +
                '<p>Por favor asegúrate de tener los documentos pertinentes para el proceso:</p>' +
                '<ul style="text-align: left;">' +
                '<li>Solicitud simple de tramite.</li>' +
                '<li>Certificado de posesion, y contrato de compra, venta o minuta.</li>' +
                '<li>Declaracion jurada de testigos.</li>' +
                '<li>Constancia negativa de propiedad emitida por SUNARP.</li>' +
                '<li>Recibo de luz, agua u otro que acredite posesion.</li>' +
                '<li>Copia de dni de cada poseedor.</li>' +
                '<li>Copia de partida de nacimiento de hijos (si tuviera).</li>' +
                '<li>Acta de matrimonio o Certificado negativo de matrimonio.</li>' +
                '<li>Certificado literal -SUNARP.</li>' +
                '<li>Plano de ubicacion perimetro y memoria descriptiva.</li>' +
                '<li>Costo administrativo.</li>' +
                '<li>Instrumento de transferencia cofopri.</li>' +
                '</ul>',
            showConfirmButton: true,
            confirmButtonText: 'Entendido'
        }).then((result) => {
            // Si el usuario hace clic en el botón "Entendido", abrir el modal
            if (result.isConfirmed) {
                // Establecer el título del modal como "Nuevo Registro"
                $('#lbltitulo').html('Nuevo Registro');

                // Limpiar el formulario de propietarios (si es necesario)
                $('#titu_id').val(''); 
                $('#cert_id').val(cert_id); 
                $('#titu_partelec').val('');
                $('#titu_numtitulo').val('');  
                $('#titu_partlote').val(''); 
                $('#titu_asiento').val(''); 
                $('#titu_serie').val(''); 
                $('#titu_tipo').val(''); 
                $('#titu_tazacion').val('0'); 
                $('#titu_emp').val(''); 
                $('#titu_sector').val('--'); 
                $('#titu_numresolucion').val(''); 
                $('#titu_fecharesolucion').val('');
                $('#titu_fechaemision').val('');  
                
                $.ajax({
                    url: "../../controller/alcalde.php?op=alcalde_activo",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.alca_id) {
                            $('#alca_id').val(response.alca_id); 
                        } else {
                            console.error('No hay alcalde activo.');
                        }
                    },
                    error: function(error) {
                        console.error('Error al obtener el alcalde activo:', error);
                    }
                });
                // Mostrar el modal de mantenimiento
                $('#modalmantenimiento').modal('show');
            }
        });
    }).fail(function() {
        console.error('Error al obtener los datos del propietario.');
    });
}

// Funciones para llenar los comboboxes
function combo_fecha_titulo() {
    $.post("../../controller/titulo.php?op=combo_fecha", function(data) {
        $('#combo_fecha_titulo').html(data);
    });
}

function combo_completo_titulo() {
    $.post("../../controller/titulo.php?op=combo_completo", function(data) {
        $('#combo_completo_titulo').html(data);
    });
}
function editar(titu_id){
    $.post("../../controller/titulo.php?op=editar_modal_titulo", { titu_id: titu_id }, function (data) {
        data = JSON.parse(data);

        $('#titu_id').val(data.titu_id);
        $('#cert_id').val(data.cert_id);
        $('#alca_id').val(data.alca_id);
        $('#titu_partelec').val(data.titu_partelec);
        $('#titu_numtitulo').val(data.titu_numtitulo);
        $('#titu_partlote').val(data.titu_partlote);
        $('#titu_asiento').val(data.titu_asiento);
        $('#titu_serie').val(data.titu_serie);
        $('#titu_tipo').val(data.titu_tipo).trigger('change');
        $('#titu_tazacion').val(data.titu_tazacion);
        $('#titu_emp').val(data.titu_emp);
        $('#titu_sector').val(data.titu_sector);
        $('#titu_numresolucion').val(data.titu_numresolucion);
        $('#titu_fecharesolucion').val(data.titu_fecharesolucion);
        $('#titu_fechaemision').val(data.titu_fechaemision);
       
        // Actualizar el título del modal
        $('#lbltitulo').html('Editar Registro');
        // Mostrar el modal
        $('#modalmantenimiento').modal('show');


    });
}

function entregar(titu_id){
    Swal.fire({
        title: '¿Está seguro?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Acción cuando el usuario hace clic en Aceptar
            
                    
                    $.post("../../controller/titulo.php?op=cambiar_estentrega",{titu_id : titu_id}, function (response) {
                    $('#titulos_data').DataTable().ajax.reload(); // Recargar los datos en la tabla
                    
                    Swal.fire({
                        title: 'Correcto!',
                        text: 'Se registró correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                   
                
            });
        } 
    });
}
function completar(titu_id){
    
    
    $('#titu_id_completar').val(titu_id);
    $('#titu_numrecibo').val(''); 

    $('#modalmantenimientocompletar').modal('show');

}
function adjuntar(titu_id) {
    
    $('#titux_idx').val(titu_id);
    $('#modalfile').modal('show');
}
function eliminar(titu_id, cert_id){
    Swal.fire({
        title: "Eliminar!",
        text: "Desea Eliminar el Registro?",
        icon: "error",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.isConfirmed) {
            // Primera llamada AJAX para eliminar el registro
            $.post("../../controller/titulo.php?op=eliminar", { titu_id: titu_id }, function(data) {
                // Segunda llamada AJAX para cambiar el estado
                $.post("../../controller/certificado.php?op=cambiar_estnotitulado", { cert_id: cert_id }, function(data) {
                    // Recargar la tabla
                    $('#titulos_data').DataTable().ajax.reload(function () {
                        // Una vez recargada la tabla, actualizar los totales
                        total_titulos_registrados();
                        total_titulos_pendientes();
                        total_titulos_completados();
                    });
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        title: 'Correcto!',
                        text: 'Se Eliminó Correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                }).fail(function() {
                    // Manejo del error de la segunda llamada AJAX
                    Swal.fire({
                        title: 'Error!',
                        text: 'Ocurrió un error al cambiar el estado.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                });
            }).fail(function() {
                // Manejo del error de la primera llamada AJAX
                Swal.fire({
                    title: 'Error!',
                    text: 'Ocurrió un error al eliminar el registro.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
        }
    });
}

function recibo(titu_id) {
    $('#titu_id_completar').val(titu_id);
    $('#titu_numrecibo').val(''); 

    $('#modalmantenimientocompletar').modal('show');
}


function titulo(){
    
    // Establecer el título del modal como "Nuevo Registro"
    $('#lbltitulo').html('Nuevo Titulo');
    
    // Limpiar el formulario de titulos
    
    
    // Mostrar el modal
    $('#modalmantenimiento').modal('show');
}
function generar(titu_id){
    

    redirect_by_post(
        "../../controller/titulo.php?op=imprimir",
        { titu_id, titu_id },
        true
      );
    
        $.post("../../controller/titulo.php?op=cambiar_estimp",{titu_id : titu_id}, function (data) {
            $('#titulos_data').DataTable().ajax.reload(function () {
                // Una vez recargada la tabla, actualizar los totales
                total_titulos_registrados();
                total_titulos_pendientes();
                total_titulos_completados();
            });

            
        });
}
function vistaprevia(titu_id) {
    // Realizar una solicitud AJAX para obtener el documento en Base64
    $.ajax({
        url: "../../controller/titulo.php?op=vistaprevia_pdf", // Asegúrate de que la ruta sea correcta
        type: 'POST',
        data: {titu_id: titu_id},
        success: function(response) {
            if (response) {
                // Crear una ventana emergente o modal para mostrar el documento
                let popup = window.open("", "Vista Previa", "width=800,height=600");
                
                // Especificar el tipo de documento, en este caso, un PDF
                popup.document.write('<iframe src="data:application/pdf;base64,' + response + '" width="100%" height="100%"></iframe>');
            } else {
                alert('No se pudo obtener el documento.');
            }
        },
        error: function(error) {
            console.error("Error al obtener el documento: ", error);
            alert('Error al obtener el documento.');
        }
    });
}
function imp_masivo(){
    

    redirect_by_post(
        "../../controller/titulo.php?op=imprimir_x_imp"
       
      );
      $('#titulos_data').DataTable().ajax.reload(function () {
        // Una vez recargada la tabla, actualizar los totales
        total_titulos_registrados();
        total_titulos_pendientes();
        total_titulos_completados();
    });
       
}

function total_titulos_registrados(){
    $.post("../../controller/titulo.php?op=total_registrados", function (data) {
        
        data = JSON.parse(data);
        $('#lblregistrados').html(data.registrados); //registrados es el nombre del casillero count(*) as registrados
    });

}
function total_titulos_pendientes(){
    $.post("../../controller/titulo.php?op=total_pendientes", function (data) {
        
        data = JSON.parse(data);
        $('#lblpendientes').html(data.pendientes); 
    });

}
function total_titulos_completados(){
    $.post("../../controller/titulo.php?op=total_completados", function (data) {
        
        data = JSON.parse(data);
        $('#lblcompletados').html(data.completados);
    });

}
function firmar(titu_id) {
    Swal.fire({
        title: "Firma!",
        text: "Desea firmar?",
        icon: "warning",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.isConfirmed) {
            // Primera llamada AJAX para cambiar el estado a firmado
            $.post("../../controller/titulo.php?op=cambiar_estfirmado", { titu_id: titu_id })
                .done(function() {
                    // Tercera llamada AJAX para cambiar el estado a no adjuntado
                    return $.post("../../controller/certificado.php?op=cambiar_esttitulado", { titu_id: titu_id });
                })
                .done(function() {
                    // Segunda llamada AJAX para cambiar el estado a no impreso
                    return $.post("../../controller/titulo.php?op=cambiar_estnoimp", { titu_id: titu_id });
                })
                .done(function() {
                    // Tercera llamada AJAX para cambiar el estado a no adjuntado
                    return $.post("../../controller/titulo.php?op=cambiar_estnoadjuntado", { titu_id: titu_id });
                })
                .done(function() {
                    // Recargar la tabla y actualizar los totales después de todas las llamadas AJAX exitosas
                    $('#titulos_data').DataTable().ajax.reload(function() {
                        total_titulos_registrados();
                        total_titulos_pendientes();
                        total_titulos_completados();
                    });
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        title: 'Correcto!',
                        text: 'Se Firmó Correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                })
                .fail(function() {
                    // Manejo del error de las llamadas AJAX
                    Swal.fire({
                        title: 'Error!',
                        text: 'Ocurrió un error al cambiar el estado.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                });
        }
    });
}
function guardaryeditarimg(e) {
    e.preventDefault();

    // Mostrar el cuadro de diálogo de confirmación
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Esta seguro?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, proceder con la solicitud AJAX
            var formData = new FormData($("#adjuntar_form")[0]);
            $.ajax({
                url: "../../controller/titulo.php?op=update_pdf",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                        
                        var titu_id = $("#adjuntar_form input[name='titux_idx']").val();
                    $.post("../../controller/titulo.php?op=cambiar_estadjuntado", { titu_id: titu_id }, function(data) {
                        // Recargar la tabla
                        $('#titulos_data').DataTable().ajax.reload(function() {
                            // Una vez recargada la tabla, actualizar los totales
                            total_titulos_registrados();
                            total_titulos_pendientes();
                            total_titulos_completados();
                        });
                        Swal.fire({
                            title: 'Correcto!',
                            text: 'Se Actualizó Correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
                        $("#modalfile").modal('hide');
                    });
                },
                error: function(error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al actualizar',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }
    });
}
function abrir(titu_id) {
    // Primero obtener el archivo base64
    $.post("../../controller/titulo.php?op=obtener_titulo_abrir", { titu_id: titu_id })
        .done(function(data) {
            try {
                // `data` debería ser la cadena base64 del PDF
                // Decodificar el string base64
                const binaryString = atob(data);

                // Crear un array buffer para almacenar el binario del PDF
                const len = binaryString.length;
                const bytes = new Uint8Array(len);
                for (let i = 0; i < len; i++) {
                    bytes[i] = binaryString.charCodeAt(i);
                }

                // Crear un blob con el tipo MIME adecuado (application/pdf)
                const blob = new Blob([bytes], { type: 'application/pdf' });

                // Crear una URL para el blob y abrir en una nueva ventana
                const url = URL.createObjectURL(blob);
                window.open(url);

                // Luego cambiar el estado del titulo
                $.post("../../controller/titulo.php?op=cambiar_estimp", { titu_id: titu_id })
                    .done(function() {
                        console.log('Estado del titulo cambiado con éxito.');
                        // Recargar la tabla después de cambiar el estado
                        $('#titulos_data').DataTable().ajax.reload(function() {
                            total_titulos_registrados();
                            total_titulos_pendientes();
                            total_titulos_completados();
                        });
                    })
                    .fail(function() {
                        console.error('Error al cambiar el estado del titulo.');
                    });
            } catch (error) {
                console.error('Error al decodificar el archivo base64:', error);
            }
        })
        .fail(function() {
            console.error('Error al obtener el archivo base64.');
        });
}
function entregar(titu_id){
    Swal.fire({
        title: '¿Está seguro?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Acción cuando el usuario hace clic en Aceptar
            
                    
                    $.post("../../controller/titulo.php?op=cambiar_estentrega",{titu_id : titu_id}, function (response) {
                    $('#titulos_data').DataTable().ajax.reload(); // Recargar los datos en la tabla
                    
                    Swal.fire({
                        title: 'Correcto!',
                        text: 'Se registró correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                   
                
            });
        } 
    });
}
$(document).ready(function() {
    // Restringir a solo números y mostrar mensaje de error
    function applyNumberValidation() {
        $('input[data-only-numbers]').on('input', function() {
            const input = $(this);
            const value = input.val();
            const errorId = `${input.attr('id')}_error`;
            if (/[^\d]/.test(value)) {
                // Mostrar mensaje de error
                $(`#${errorId}`).text('Por favor, ingrese solo números.').show();
            } else {
                // Ocultar mensaje de error
                $(`#${errorId}`).hide();
            }
            input.val(value.replace(/[^0-9]/g, ''));
        });
    }

    // Restringir a solo letras y mostrar mensaje de error
    function applyLetterValidation() {
        $('input[data-only-letters]').on('input', function() {
            const input = $(this);
            const value = input.val();
            const errorId = `${input.attr('id')}_error`;
            if (/[^a-zA-Z\s]/.test(value)) {
                // Mostrar mensaje de error
                $(`#${errorId}`).text('Por favor, ingrese solo letras.').show();
            } else {
                // Ocultar mensaje de error
                $(`#${errorId}`).hide();
            }
            input.val(value.replace(/[^a-zA-Z\s]/g, ''));
        });
    }

    $('#modalmantenimiento').on('shown.bs.modal', function() {
        applyNumberValidation();
        applyLetterValidation();
    });
});
function redirect_by_post(purl, pparameters, in_new_tab) {
    pparameters = typeof pparameters == "undefined" ? {} : pparameters;
    in_new_tab = typeof in_new_tab == "undefined" ? true : in_new_tab;
  
    var form = document.createElement("form");
    $(form)
      .attr("id", "reg-form")
      .attr("name", "reg-form")
      .attr("action", purl)
      .attr("method", "post")
      .attr("enctype", "multipart/form-data");
    if (in_new_tab) {
      $(form).attr("target", "_blank");
    }
    $.each(pparameters, function (key) {
      $(form).append(
        '<input type="text" name="' + key + '" value="' + this + '" />'
      );
    });
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
  
    return false;
  }
  init();