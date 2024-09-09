let propietarioIndex = 0; 

$(document).ready(function(){
    'use strict';

    // Configuración del wizard
    $('#wizard4').steps({
        headerTag: 'h3',
        bodyTag: 'section',
        autoFocus: true,
        startIndex: 0, // Siempre inicia en el primer paso
        titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
        onStepChanging: function (event, currentIndex, newIndex) {
            if (currentIndex < newIndex) {
                // Validación del paso 1 (propietarios_form)
                if (currentIndex === 0) {
                    var $formStep1 = $('#propietarios_form');
                    $formStep1.parsley(); // Inicializa Parsley para el formulario
                    return $formStep1.parsley().validate();
                }
                // Validación del paso 2 (certificados_form)
                if (currentIndex === 1) {
                    var $formStep2 = $('#certificados_form');
                    $formStep2.parsley(); // Inicializa Parsley para el formulario
                    return $formStep2.parsley().validate();
                }
            } else {
                // Siempre permite el retroceso al paso anterior
                return true;
            }
        },
        onFinishing: function (event, currentIndex) {
            // Validación final en el paso 2 (certificados_form)
            var $formStep2 = $('#certificados_form');
            $formStep2.parsley(); // Inicializa Parsley para el formulario
            return $formStep2.parsley().validate();
        }
    });

    // Asegura que el wizard siempre comience en el primer paso al mostrar el modal
    $('#modalmantenimiento').on('shown.bs.modal', function () {
        $('#wizard4').steps('setStep', 0);
    });
});

      
    init();
    
    function init() {
        $('#btnGuardar').on('click', function(e) {
            e.preventDefault();
    
            // Inicializar Parsley para ambos formularios
            var $formStep1 = $('#propietarios_form').parsley();
            var $formStep2 = $('#certificados_form').parsley();
    
            // Validar ambos formularios
            var isPropietariosValid = $formStep1.validate();
            var isCertificadosValid = $formStep2.validate();
    
            // Si ambos formularios son válidos, proceder con la acción de guardar
            if (isPropietariosValid && isCertificadosValid) {
                guardaryeditar(e);
            } else {
                // Mostrar los errores sin enfocar manualmente
                if (!isPropietariosValid) {
                    $formStep1.$element.find('.parsley-error').each(function() {
                        $(this).addClass('parsley-error');
                    });
                }
                if (!isCertificadosValid) {
                    $formStep2.$element.find('.parsley-error').each(function() {
                        $(this).addClass('parsley-error');
                    });
                }
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
    }


function guardaryeditar(e) {
    e.preventDefault();

    const propietariosForm = $('#propietariosContainer').find('input, select').serializeArray();
    const certificadosForm = $('#certificados_form').serializeArray();

    if (!propietariosForm) {
        console.error('Formulario de propietarios no encontrado');
        return;
    }
    if (!certificadosForm) {
        console.error('Formulario de certificados no encontrado');
        return;
    }

    const formDataCombined = {};
    propietariosForm.forEach(field => {
        formDataCombined[field.name] = field.value;
    });
    certificadosForm.forEach(field => {
        formDataCombined[field.name] = field.value;
    });

    console.log(formDataCombined);

        $.ajax({
            url: "../../controller/certificado.php?op=guardaryeditar",
            type: "POST",
            data: formDataCombined,
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            processData: true,
            success: function(data){
               console.log(data);
               $('#certificados_data').DataTable().ajax.reload(function () {
                    total_certificados_registrados();
                    total_certificados_pendientes();
                    total_certificados_completados();
                });
    
                Swal.fire({
                    title: 'Correcto!',
                    text: 'Se Registró Correctamente',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Imprimir'
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.cancel) {
                        // Aquí puedes realizar la acción de imprimir
                        generar(titu_id);
                    }
                });
            }
        });
        
        
        $('#modalmantenimiento').modal('hide');
    }


$(document).ready(function(){
    
    combo_fecha_certificado();
    combo_completo_certificado();
    

    combo_inspector();
    combo_tipovia();
    combo_tipourbanizacion();
    

    
    
    total_certificados_registrados();
    total_certificados_pendientes();
    total_certificados_completados();
    
    
$('#certificados_data').DataTable({
    

    "aProcessing": true,
    "aServerSide": true,
    dom: 'Bfrtip',
    buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
    ],
    "ajax": {
            "url": "../../controller/certificado.php?op=mostrar_certificado_propietario",
            "type": "POST",
            "data": function (d) {
                d.fecha = $('#combo_fecha_certificado').val();
                d.completo = $('#combo_completo_certificado').val();
            
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
// Event listener para los comboboxes de certificados
$('#combo_fecha_certificado, #combo_completo_certificado').change(function() {
    $('#certificados_data').DataTable().ajax.reload();
});




// Funciones para llenar los comboboxes
function combo_fecha_certificado() {
    $.post("../../controller/certificado.php?op=combo_fecha", function(data) {
        $('#combo_fecha_certificado').html(data);
    });
}

function combo_completo_certificado() {
    $.post("../../controller/certificado.php?op=combo_completo", function(data) {
        $('#combo_completo_certificado').html(data);
    });
}

function combo_inspector() {
    $.post("../../controller/inspector.php?op=combo", function (data) {
        
        $('#insp_id').html(data);
        $('#insp_id').select({
            dropdownParent: $('#modalmantenimiento')
        });
    });
}


function combo_tipourbanizacion(){
    $.post("../../controller/tipourbanizacion.php?op=combo", function (data) {
       
        $('#tiur_id').html(data);
        $('#tiur_id').select({
            dropdownParent: $('#modalmantenimiento')
        });
    });
}
function combo_tipovia(){
    $.post("../../controller/tipovia.php?op=combo", function (data) {
        $('#tivi_id').html(data);
        $('#tivi_id').select({
            dropdownParent: $('#modalmantenimiento')
        });
    });
}
function vistaprevia(cert_id) {
    // Realizar una solicitud AJAX para obtener el documento en Base64
    $.ajax({
        url: "../../controller/certificado.php?op=vistaprevia_pdf", // Asegúrate de que la ruta sea correcta
        type: 'POST',
        data: {cert_id: cert_id},
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
function completar(cert_id){
    $.post("../../controller/propietario.php?op=mostrar_editar_modal", { cert_id: cert_id }, function (data) {
        data = JSON.parse(data);
        // Limpiar el contenedor de propietarios
    $('#infopropietarioContainer').empty();

        data.forEach((prop, index) => {
            // Crear un nuevo contenedor de propietario
            let propHtml = `
                        <div class="info-container">
                            <div class="info-box">
                                <h2>Información Propietario</h2>
                                <p><strong>Nombre: ${prop.prop_nombre} ${prop.prop_apep} ${prop.prop_apem}</strong> </p>
                                <p><strong>DNI:</strong> ${prop.prop_dni} </p>
                                <p><strong>Estado Civil:</strong> ${prop.prop_estadocivil}</p>
                            </div>
                        </div>
                       

            `;
    
            // Añadir el nuevo contenedor de propietario al DOM
            $('#infopropietarioContainer').append(propHtml);
    
            // Aplicar cualquier plugin de terceros si es necesario (por ejemplo, select2)
            
            $('#prop_estadocivil_' + (index + 1)).trigger('change');
      
    });
    
    });
    $('#modalmantenimientocompletar').modal('show');
        /* $.post("../../controller/certificado.php?op=cambiar_completar",{cert_id : cert_id}, function (data) {
            $('#certificados_data').DataTable().ajax.reload();

            
        }); */

}

function titulo(cert_id) {
    // Primero cambiar el estado
    $.ajax({
        url: "../../controller/alcalde.php?op=alcalde_cambiarestado",
        type: 'post',
        dataType: 'json',
        success: function(response) {
            // Una vez cambiado el estado, comprobar si hay alcaldes activos
            $.ajax({
                url: "../../controller/alcalde.php?op=alcalde_comprobar",
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    console.log(response);  // Ver la respuesta en la consola para depuración

                    if (response.status === 'success') {
                        // Si hay alcaldes activos, redirigir a UsuTitulo
                        localStorage.setItem('cert_id', cert_id);
                        window.location.href = "../../view/UsuTitulo";
                    } else {
                        // Si no hay alcaldes activos, mostrar mensaje y redirigir a MntAlcalde
                        alert("El tiempo del alcalde ya expiró. No puede avanzar si no hay un alcalde activo.");
                        window.location.href = "../../view/MntAlcalde";
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX al comprobar:", status, error);
                    alert("Hubo un error al intentar comprobar el estado de los alcaldes.");
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX al cambiar estado:", status, error);
            alert("Hubo un error al intentar cambiar el estado.");
        }
    });
}
function generar(cert_id){
    console.log(cert_id);

    redirect_by_post(
        "../../controller/certificado.php?op=imprimir",
        { cert_id, cert_id },
        true
      );
    
        $.post("../../controller/certificado.php?op=cambiar_estimp",{cert_id : cert_id}, function (data) {
            $('#certificados_data').DataTable().ajax.reload(function () {
                // Una vez recargada la tabla, actualizar los totales
                total_certificados_registrados();
                total_certificados_pendientes();
                total_certificados_completados();
            });

            
        });

}
function imp_masivo(){
    

    redirect_by_post(
        "../../controller/certificado.php?op=imprimir_x_imp"
       
      );
      $('#certificados_data').DataTable().ajax.reload(function () {
                total_certificados_registrados();
                total_certificados_pendientes();
                total_certificados_completados();
            });
}

function imp_masivo_completo(){
    

    redirect_by_post(
        "../../controller/certificado.php?op=imprimir_x_firm3"
       
      );
      $('#certificados_data').DataTable().ajax.reload(function () {
        total_certificados_registrados();
        total_certificados_pendientes();
        total_certificados_completados();
    });
       
}
function total_certificados_registrados(){
    $.post("../../controller/certificado.php?op=total_registrados", function (data) {
        
        data = JSON.parse(data);
        $('#lblregistrados').html(data.registrados); //registrados es el nombre del casillero count(*) as registrados
    });

}
function total_certificados_pendientes(){
    $.post("../../controller/certificado.php?op=total_pendientes", function (data) {
        
        data = JSON.parse(data);
        $('#lblpendientes').html(data.pendientes); 
    });

}
function total_certificados_completados(){
    $.post("../../controller/certificado.php?op=total_completados", function (data) {
        
        data = JSON.parse(data);
        $('#lblcompletados').html(data.completados);
    });

}
function nuevo() {
    
    Swal.fire({
        icon: 'info',
        title: 'Tener en cuenta',
        html: '<p>Por favor asegúrate de tener los documentos pertinentes para el proceso:</p>' +
              '<ul style="text-align: left;">' +
              '<li>Derecho de inspección.</li>' +
              '<li>Resolución de certificado.</li>' +
              '</ul>',
        showConfirmButton: true,
        confirmButtonText: 'Entendido'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#lbltitulo').html('Nuevo Registro');
            $('#propietariosContainer').empty();

            let propHtml = `
                <br>
                <h4>Propietario 1
                </h4>
                <div class="propietario_0" id="propietario_0">
                    <input type="hidden" name="propietarios[0][prop_id]" value=""/>
                    <div class="form-layout form-layout-1" style="background-color: white;">
                        <div class="row mg-b-10">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label">DNI/RUC: <span class="tx-danger">*</span></label>
                                    <input class="form-control" 
                                        type="text" 
                                        name="propietarios[0][prop_dni]" 
                                        id="dni_0" 
                                        value="" 
                                        placeholder="DNI" 
                                        required 
                                        data-parsley-required-message="Este campo es obligatorio" />
                                    <small id="dni_0_error" class="form-text text-danger" style="display:none;">Por favor, ingrese solo números.</small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">Tipo: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="propietarios[0][prop_tipo]" id="tipo_0" value="" placeholder="Tipo" required data-parsley-required-message="Este campo es obligatorio" READONLY>
                                </div>
                            </div><!-- col-4 -->


            
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="propietarios[0][prop_nombre]" id="nombre_0" value="" placeholder="Nombre" READONLY required data-parsley-required-message="Este campo es obligatorio"/>
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">Apellido P.: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="propietarios[0][prop_apep]" id="apellidoP_0" value="" placeholder="Apellido Paterno" READONLY/>
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">Apellido M.: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="propietarios[0][prop_apem]" id="apellidoM_0" value="" placeholder="Apellido Materno" READONLY/>
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">E. civil <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="propietarios[0][prop_estadocivil]" id="estadoCivil_0" placeholder="Selecciona" READONLY>
                                </div>
                            </div><!-- col-4 -->
                        </div><!-- row -->
                    </div><!-- form-layout -->
                </div>
            `;

            $('#propietariosContainer').append(propHtml);

            // Registrar el evento change en el nuevo campo DNI
            $(`#dni_0`).on('change', function() {
                consultar(0);
            });

            // Restringir la entrada a solo dígitos (0-9) y validar
            $(`#dni_0`).on('input', function() {
                validar_dni(0);
            });

            $('#cert_id').val('');
            $('#insp_id').val(''); 
            $('#tivi_id').val('').trigger('change');
            $('#cert_nomtipovia').val('');
            $('#cert_manzana').val(''); 
            $('#cert_lote').val(''); 
            $('#cert_etapa').val('--');
            $('#tiur_id').val('').trigger('change');
            $('#cert_nomtipourb').val('');
            $('#cert_uso').val(''); 
            $('#cert_perimetro').val(''); 
            $('#cert_area').val(''); 
            $('#cert_frente').val(''); 
            $('#cert_derecha').val(''); 
            $('#cert_izquierda').val(''); 
            $('#cert_fondo').val('');
            $('#cert_medfrente').val(''); 
            $('#cert_medderecha').val(''); 
            $('#cert_medizquierda').val(''); 
            $('#cert_medfondo').val('');
            $('#cert_numregdoc').val(''); 
            $('#cert_tecinf').val(''); 
            $('#cert_numactainsp').val('S/N'); 
            $('#cert_numrecibo_derinsp').val('');

            $('#modalmantenimiento').modal('show');

            // Restringir la entrada a solo dígitos (0-9)
            
        }
    });
}
function editar(cert_id) {
    $.post("../../controller/propietario.php?op=mostrar_editar_modal", { cert_id: cert_id }, function (data) {
        data = JSON.parse(data);
        console.log(data); // Verifica los datos que estás recibiendo

        // Verificar si el contenedor de propietarios existe
        const propietariosContainer = $('#propietariosContainer');

        // Limpiar el contenedor de propietarios
        propietariosContainer.empty();

        // Iterar sobre cada propietario en data
        data.forEach((prop, index) => {
            // Crear un nuevo contenedor de propietario
            let propHtml = `
                <br>
                <h4>Propietario ${index + 1}</h4>
                <div class="propietario_${index}" id="propietario_${index}">
                    <input name="propietarios[${index}][prop_id]" value="${prop.prop_id}" hidden/>
                    <div class="form-layout form-layout-1" style="background-color: white;">
                        <div class="row mg-b-10">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label">DNI/RUC: <span class="tx-danger">*</span></label>
                                    <input class="form-control" 
                                        type="text" 
                                        name="propietarios[${index}][prop_dni]" 
                                        id="dni_${index}" 
                                        value="${prop.prop_dni}" 
                                        placeholder="DNI" 
                                        required 
                                        data-parsley-required-message="Este campo es obligatorio" />
                                    <small id="dni_${index}_error" class="form-text text-danger" style="display:none;">Por favor, ingrese solo números.</small>
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">Tipo: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="tipo_${index}" type="text" name="propietarios[${index}][prop_tipo]" value="${prop.prop_tipo}" placeholder="Tipo" required data-parsley-required-message="Este campo es obligatorio" READONLY>
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-5">
                                <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="nombre_${index}" type="text" name="propietarios[${index}][prop_nombre]" value="${prop.prop_nombre}" placeholder="Nombre" required data-parsley-required-message="Este campo es obligatorio" READONLY/>
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Apellido P.: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="apellidoP_${index}" type="text" name="propietarios[${index}][prop_apep]" value="${prop.prop_apep}" placeholder="Apellido Paterno" READONLY/>
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Apellido M.: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="apellidoM_${index}" type="text" name="propietarios[${index}][prop_apem]" value="${prop.prop_apem}" placeholder="Apellido Materno" READONLY/>
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">E. civil <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="estadoCivil_${index}" type="text" name="propietarios[${index}][prop_estadocivil]" value="${prop.prop_estadocivil}" placeholder="Estado Civil" READONLY>
                                </div>
                            </div><!-- col-4 -->
                        </div><!-- row -->
                        ${index > 0 ? `<button type="button" class="btn btn-danger" onclick="removePropietario('propietario_${index}')">Eliminar</button>` : ''}
                    </div><!-- form-layout -->
                </div>
            `;

            // Añadir el nuevo contenedor de propietario al DOM
            propietariosContainer.append(propHtml);

            // Registrar el evento change en el campo DNI para este propietario
            $(`#dni_${index}`).on('change', function() {
                consultar(index);
            });
            // Restringir la entrada a solo dígitos (0-9) y validar
            $(`#dni_${index}`).on('input', function() {
                validar_dni(index);
            });
            // Realizar la consulta inicial para llenar los campos si es necesario
            consultar(index);
        });

        // Desactivar el botón para agregar propietarios si ya hay 2
        if (data.length >= 2) {
            $('#addpropietario').prop('disabled', true);
        } else {
            $('#addpropietario').prop('disabled', false);
        }
    });

    $.post("../../controller/certificado.php?op=editar_modal_certificado", { cert_id: cert_id }, function (data) {
        data = JSON.parse(data);

        $('#certificadosContainer').empty();

        $('#cert_id').val(data.cert_id);
        $('#insp_id').val(data.insp_id).trigger('change');
        $('#tivi_id').val(data.tivi_id).trigger('change');
        $('#tiur_id').val(data.tiur_id).trigger('change');
        $('#cert_nomtipourb').val(data.cert_nomtipourb);
        $('#cert_nomtipovia').val(data.cert_nomtipovia);
        $('#cert_area').val(data.cert_area);
        $('#cert_perimetro').val(data.cert_perimetro);
        $('#cert_uso').val(data.cert_uso);
        $('#cert_frente').val(data.cert_frente);
        $('#cert_derecha').val(data.cert_derecha);
        $('#cert_izquierda').val(data.cert_izquierda);
        $('#cert_fondo').val(data.cert_fondo);

        $('#cert_medfrente').val(data.cert_medfrente);
        $('#cert_medderecha').val(data.cert_medderecha);
        $('#cert_medizquierda').val(data.cert_medizquierda);
        $('#cert_medfondo').val(data.cert_medfondo);

        $('#cert_manzana').val(data.cert_manzana);
        $('#cert_lote').val(data.cert_lote);
        $('#cert_etapa').val(data.cert_etapa);

        $('#cert_numregdoc').val(data.cert_numregdoc);

        $('#cert_tecinf').val(data.cert_tecinf);
        $('#cert_numactainsp').val(data.cert_numactainsp);
        $('#cert_numrecibo_derinsp').val(data.cert_numrecibo_derinsp);
    });

    // Actualizar el título del modal
    $('#lbltitulo').html('Editar Registro');
    // Mostrar el modal
    $('#modalmantenimiento').modal('show');
}



function addPropietario() {
    propietarioIndex++; // Incrementar el índice de propietario
    const propietariosContainer = document.getElementById('propietariosContainer');
    const nuevoPropietario = document.createElement('div');
    nuevoPropietario.classList.add('propietario');
    nuevoPropietario.id = `propietario_${propietarioIndex}`;
    nuevoPropietario.innerHTML = `
        <br>
        <h4>Propietario ${propietarioIndex + 1}</h4>
        <input type="hidden" name="propietarios[${propietarioIndex}][prop_id]" />
        <div class="form-layout form-layout-1" style="background-color: white;">
            <div class="row mg-b-10">
                <div class="col-lg-3">
                    <div class="form-group">
                                    <label class="form-control-label">DNI/RUC: <span class="tx-danger">*</span></label>
                                    <input class="form-control" 
                                        type="text" 
                                        name="propietarios[${propietarioIndex}][prop_dni]" 
                                        id="dni_${propietarioIndex}" 
                                        placeholder="DNI" 
                                        required 
                                        data-parsley-required-message="Este campo es obligatorio"  />
                                    <small id="dni_${propietarioIndex}_error" class="form-text text-danger" style="display:none;">Por favor, ingrese solo números.</small>
                                </div>
                </div><!-- col-4 -->
                
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-control-label">Tipo: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" name="propietarios[${propietarioIndex}][prop_tipo]" id="tipo_${propietarioIndex}" placeholder="Tipo" required data-parsley-required-message="Este campo es obligatorio" READONLY>
                    </div>
                </div><!-- col-4 -->

                
                <div class="col-lg-5">
                    <div class="form-group">
                        <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" name="propietarios[${propietarioIndex}][prop_nombre]" id="nombre_${propietarioIndex}" placeholder="Nombre" required data-parsley-required-message="Este campo es obligatorio" READONLY/>
                    </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-control-label">Apellido P.: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" name="propietarios[${propietarioIndex}][prop_apep]" id="apellidoP_${propietarioIndex}" placeholder="Apellido Paterno" READONLY/>
                    </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-control-label">Apellido M.: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" name="propietarios[${propietarioIndex}][prop_apem]" id="apellidoM_${propietarioIndex}" placeholder="Apellido Materno" READONLY/>
                    </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-control-label">E. civil <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" name="propietarios[${propietarioIndex}][prop_estadocivil]" id="estadoCivil_${propietarioIndex}" placeholder="Estado Civil" READONLY>
                    </div>
                </div><!-- col-4 -->
                
            </div><!-- row -->
            <button type="button" class="btn btn-danger" onclick="removePropietario('propietario_${propietarioIndex}')">Eliminar</button>
        </div><!-- form-layout -->
    `;
    propietariosContainer.appendChild(nuevoPropietario);

    // Registrar el evento change en el nuevo campo DNI
    $(`#dni_${propietarioIndex}`).on('change', function() {
        consultar(propietarioIndex);
    });


    $(`#dni_${propietarioIndex}`).on('input', function() {
        validar_dni(propietarioIndex);
    });
    // Deshabilitar el botón si hay 2 o más propietarios
    if (propietarioIndex > 0) {
        document.getElementById('addpropietario').disabled = true;
    }

  
}

function removePropietario(id) {
    const propietarioElement = document.getElementById(id);
    propietarioElement.parentNode.removeChild(propietarioElement);

    propietarioIndex--;
    // Habilitar el botón si hay menos de 2 propietarios
    if (propietarioIndex < 1) {
        document.getElementById('addpropietario').disabled = false;
    }
}

    
    

function entregar(cert_id){
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
            
                    
                    $.post("../../controller/certificado.php?op=cambiar_estentrega",{cert_id : cert_id}, function (response) {
                    $('#certificados_data').DataTable().ajax.reload(); // Recargar los datos en la tabla
                    
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
function adjuntar(cert_id) {
    
    $('#certx_idx').val(cert_id);  
    $('#modalfile').modal('show');
}
  

function eliminar(cert_id){
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
            
                // Segunda llamada AJAX para cambiar el estado
                $.post("../../controller/certificado.php?op=eliminar", { cert_id: cert_id }, function(data) {
                    // Recargar la tabla
                    $('#certificados_data').DataTable().ajax.reload(function () {
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
            
        }
    });
}
function firmar(cert_id) {
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
            $.post("../../controller/certificado.php?op=cambiar_estfirmado", { cert_id: cert_id })
                .done(function() {
                    // Segunda llamada AJAX para cambiar el estado a no impreso
                    return $.post("../../controller/certificado.php?op=cambiar_estnoimp", { cert_id: cert_id });
                })
                .done(function() {
                    // Tercera llamada AJAX para cambiar el estado a no adjuntado
                    return $.post("../../controller/certificado.php?op=cambiar_estnoadjuntado", { cert_id: cert_id });
                })
                .done(function() {
                    // Recargar la tabla y actualizar los totales después de todas las llamadas AJAX exitosas
                    $('#certificados_data').DataTable().ajax.reload(function() {
                        total_certificados_registrados();
                        total_certificados_pendientes();
                        total_certificados_completados();
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
function abrir(cert_id) {
    // Primero obtener el archivo base64
    $.post("../../controller/certificado.php?op=obtener_certificado_abrir", { cert_id: cert_id })
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

                // Luego cambiar el estado del certificado
                $.post("../../controller/certificado.php?op=cambiar_estimp", { cert_id: cert_id })
                    .done(function() {
                        console.log('Estado del certificado cambiado con éxito.');
                        // Recargar la tabla después de cambiar el estado
                        $('#certificados_data').DataTable().ajax.reload(function() {
                            total_titulos_registrados();
                            total_titulos_pendientes();
                            total_titulos_completados();
                        });
                    })
                    .fail(function() {
                        console.error('Error al cambiar el estado del certificado.');
                    });
            } catch (error) {
                console.error('Error al decodificar el archivo base64:', error);
            }
        })
        .fail(function() {
            console.error('Error al obtener el archivo base64.');
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
                url: "../../controller/certificado.php?op=update_pdf",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                        
                        var cert_id = $("#adjuntar_form input[name='certx_idx']").val();
                    $.post("../../controller/certificado.php?op=cambiar_estadjuntado", { cert_id: cert_id }, function(data) {
                        // Recargar la tabla
                        $('#certificados_data').DataTable().ajax.reload(function() {
                            // Una vez recargada la tabla, actualizar los totales
                            total_certificados_registrados();
                            total_certificados_pendientes();
                            total_certificados_completados();
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
function consultar(index) {
    const dni = $(`#dni_${index}`).val().trim(); // Trim para eliminar espacios innecesarios
    
    if (dni) {
        let url;

        // Determinar la URL en función de la longitud del DNI
        if (dni.length === 8) {
            url = `../../consultas/api_consultardni.php?dni=${encodeURIComponent(dni)}`;
        } else if (dni.length === 11) {
            url = `../../consultas/api_consultarruc.php?dni=${encodeURIComponent(dni)}`;
        } else {
            console.error('Longitud del DNI/RUC no válida.');
            $(`#dni_${index}_error`).text('Longitud del DNI/RUC no válida.').show();
            $(`#nombre_${index}`).val('');
            $(`#apellidoP_${index}`).val('');
            $(`#apellidoM_${index}`).val('');
            $(`#estadoCivil_${index}`).val('');
            $(`#tipo_${index}`).val('');
            return;
        }

        // Mostrar indicador de carga
        $(`#dni_${index}_error`).text('Cargando...').show();

        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const data = response.data;
        
                    if (dni.length === 8) {
                        $(`#nombre_${index}`).val(data.prenombres);
                        $(`#apellidoP_${index}`).val(data.apPrimer);
                        $(`#apellidoM_${index}`).val(data.apSegundo);
                        $(`#estadoCivil_${index}`).val(data.estadoCivil);
                        $(`#tipo_${index}`).val('PERSONA NATURAL');
                    } else if (dni.length === 11) {
                        $(`#nombre_${index}`).val(data.raz_social);
                        $(`#apellidoP_${index}`).val('');
                        $(`#apellidoM_${index}`).val('');
                        $(`#estadoCivil_${index}`).val('');
                        $(`#tipo_${index}`).val(data.tipo_persona);
                    }
        
                    // Ocultar indicador de carga y error
                    $(`#dni_${index}_error`).hide();
                } else {
                    // Mostrar mensaje de error si la respuesta indica un error
                    $(`#dni_${index}_error`).text('DNI/RUC no válido.').show();
                    $(`#nombre_${index}`).val('');
                    $(`#apellidoP_${index}`).val('');
                    $(`#apellidoM_${index}`).val('');
                    $(`#estadoCivil_${index}`).val('');
                    $(`#tipo_${index}`).val('');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al realizar la solicitud:', error);
        
                // Mostrar mensaje de error en caso de falla de la solicitud AJAX
                $(`#dni_${index}_error`).text('Error en la solicitud.').show();
                $(`#nombre_${index}`).val('');
                $(`#apellidoP_${index}`).val('');
                $(`#apellidoM_${index}`).val('');
                $(`#estadoCivil_${index}`).val('');
                $(`#tipo_${index}`).val('');
            }
        });
    } else {
        // Ocultar mensaje de error si DNI está vacío
        $(`#dni_${index}_error`).hide();
        $(`#nombre_${index}`).val('');
        $(`#apellidoP_${index}`).val('');
        $(`#apellidoM_${index}`).val('');
        $(`#estadoCivil_${index}`).val('');
        $(`#tipo_${index}`).val('');
    }
}

function validar_dni(index) {
    let dniField = $(`#dni_${index}`);
    let dni = dniField.val().trim(); // Eliminar espacios innecesarios
    
    // Eliminar cualquier carácter que no sea un dígito
    let cleanValue = dni.replace(/[^0-9]/g, '');

    // Limitar a un máximo de 11 caracteres
    if (cleanValue.length > 11) {
        cleanValue = cleanValue.substring(0, 11);
    }

    // Actualizar el valor del campo con la versión limpia y limitada
    dniField.val(cleanValue);

    // Expresión regular para verificar que el valor solo contenga dígitos
    const soloNumeros = /^\d+$/;

    if (!soloNumeros.test(cleanValue)) {
        // Mostrar mensaje de error si no es numérico
        $(`#dni_${index}_error`).text('Por favor, ingrese solo números.').show();
        return false;
    } else if (cleanValue.length >= 11) {
        // Mostrar mensaje de error si tiene más de 11 dígitos
        $(`#dni_${index}_error`).text('No es valido más de 11 dígitos.').show();
        return false;
    } else {
        // Ocultar mensaje de error si es válido
        $(`#dni_${index}_error`).hide();
        return true;
    }
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
  