var usu_id = $('#usu_idx').val();

function init(){
    
    $("#certificados_form").on("submit",function(e){
        guardaryeditar(e);
    });
}

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#certificados_form")[0]);
    $.ajax({
        url: "../../controller/certificado.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){
            console.log(data);
            $('#certificados_data').DataTable().ajax.reload();

            Swal.fire({
                title: 'Correcto!',
                text: 'Se Registro Correctamente',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            })
        }
    });
}
$(document).ready(function(){
    $('#dist_id').select2({
        dropdownParent: $('#mantenimiento')
    });
    combo_distrito();
$('#certificados_data').DataTable({
    "aProcessing": true,
    "aServerSide": true,
    dom: 'Bfrtip',
    buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
    ],
    "ajax":{
        url:"../../controller/certificado.php?op=listar",
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
function combo_distrito(){
    $.post("../../controller/distrito.php?op=combo", function (data) {
        $('#dist_id').html(data);
    });
}
function editar(cert_id){
    $.post("../../controller/certificado.php?op=mostrar",{cert_id : cert_id}, function (data) {
        data = JSON.parse(data);
        $('#cert_id').val(data.cert_id);
        $('#insp_id').val(data.insp_id);
        $('#cert_area').val(data.cert_area);
        $('#cert_perimetro').val(data.cert_perimetro);
        $('#cert_ubicacion').val(data.cert_ubicacion);
        $('#cert_nompobl').val(data.cert_nompobl);
        $('#cert_tipopobl').val(data.cert_tipopobl).trigger('change');
        $('#cert_uso').val(data.cert_uso);
        $('#cert_frente').val(data.cert_frente);
        $('#cert_derecha').val(data.cert_derecha);
        $('#cert_izquierda').val(data.cert_izquierda);
        $('#cert_fondo').val(data.cert_fondo);
        $('#cert_manzana').val(data.cert_manzana);
        $('#cert_lote').val(data.cert_lote);
        $('#cert_distrito').val(data.cert_distrito);
        $('#cert_provincia').val(data.cert_provincia);
        $('#cert_departamento').val(data.cert_departamento);
        $('#cert_numregdoc').val(data.cert_numregdoc);
        $('#cert_numexpe').val(data.cert_numexpe);
        $('#cert_tecinf').val(data.cert_tecinf);
        $('#cert_numcert').val(data.cert_numcert);
        $('#cert_numactainsp').val(data.cert_numactainsp);


    });

    
}

function eliminar(cert_id){
    swal.fire({
        title: "Eliminar!",
        text: "Desea Eliminar el Registro?",
        icon: "error",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.value) {
            $.post("../../controller/certificado.php?op=eliminar",{cert_id : cert_id}, function (data) {
                $('#certificados_data').DataTable().ajax.reload();

                Swal.fire({
                    title: 'Correcto!',
                    text: 'Se Elimino Correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                })
            });
        }
    });
}


init();