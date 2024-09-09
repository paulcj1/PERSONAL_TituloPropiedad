function init(){
    
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
} 

$(document).ready(function(){
    total_titulos_pendientes();
    total_titulos_descargables();
$('#titulos_data').DataTable({
    "aProcessing": true,
    "aServerSide": true,
    dom: 'Bfrtip',
    buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
    ],
    "ajax":{
        url:"../../controller/titulo.php?op=listar_titulos_pendiente_gerente",
        type:"post"
    },
    "bDestroy": true,
    "responsive": false,
    "bInfo":true,
    "iDisplayLength": 10,
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
});
});

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
            $.post("../../controller/titulo.php?op=cambiar_estfirmado3", { titu_id: titu_id })
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
                        total_titulos_pendientes();
                        total_titulos_descargables();
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
                            total_titulos_pendientes();
                            total_titulos_descargables();
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
function adjuntar(titu_id) {
    
    $('#titux_idx').val(titu_id);
    $('#modalfile').modal('show');
}
function imp_masivo(){
    

    redirect_by_post(
        "../../controller/titulo.php?op=imprimir_x_firm2"
       
      );
      $('#titulos_data').DataTable().ajax.reload(function () {
        // Una vez recargada la tabla, actualizar los totales
        total_titulos_pendientes();
        total_titulos_descargables();
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
                            total_titulos_pendientes();
                            total_titulos_descargables();
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
function total_titulos_pendientes(){
    $.post("../../controller/titulo.php?op=total_pendientes_gerente", function (data) {
        
        data = JSON.parse(data);
        $('#lblpendientes').html(data.pendientes); 
    });

}
function total_titulos_descargables(){
    $.post("../../controller/titulo.php?op=total_descargables_gerente", function (data) {
        
        data = JSON.parse(data);
        $('#lbldescargables').html(data.descargables);
    });

}
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