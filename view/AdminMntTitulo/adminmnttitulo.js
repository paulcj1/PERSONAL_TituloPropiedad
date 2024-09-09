var usu_id = $('#usu_idx').val();

function init(){
    
    $("#titulos_form").on("submit",function(e){
        guardaryeditar(e);
    });
}

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#titulos_form")[0]);
    $.ajax({
        url: "../../controller/titulo.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){
            console.log(data);
            $('#titulos_data').DataTable().ajax.reload();

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
        url:"../../controller/titulo.php?op=listar",
        type:"post"
    },
    "bDestroy": true,
    "responsive": true,
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

function editar(titu_id){
    $.post("../../controller/titulo.php?op=mostrar",{titu_id : titu_id}, function (data) {
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
        $('#titu_numresolucion').val(data.titu_numresolucion);
        $('#titu_fecharesolucion').val(data.titu_fecharesolucion);
        $('#titu_fechaemision').val(data.titu_fechaemision);

    });
    
    
}

init();