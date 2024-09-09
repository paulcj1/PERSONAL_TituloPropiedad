var usu_id = $('#usu_idx').val();
function init(){
    $("#alcaldes_form").on("submit",function(e){
        guardaryeditar(e);
    });
}
function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#alcaldes_form")[0]);
    $.ajax({
        url: "../../controller/alcalde.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){
            console.log(data);
            $('#alcaldes_data').DataTable().ajax.reload();

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

    $('#alcaldes_data').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
        "ajax":{
            url:"../../controller/alcalde.php?op=listar",
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

function nuevo(){
    
    $('#alca_id').val('');
    $('#alca_nom').val('');
    $('#alca_apep').val('');
    $('#alca_apem').val('');
    $('#alca_dni').val('');
    $('#alca_fechini').val('');
    $('#alca_fechfin"').val('');
    
}

function editar(alca_id){
    $.post("../../controller/alcalde.php?op=mostrar",{alca_id : alca_id}, function (data) {
        data = JSON.parse(data);
        $('#alca_id').val(data.alca_id);
        $('#alca_nom').val(data.alca_nom);
        $('#alca_apep').val(data.alca_apep);
        $('#alca_apem').val(data.alca_apem);
     
        $('#alca_dni').val(data.alca_dni);
        $('#alca_fechini').val(data.alca_fechini);
        $('#alca_fechfin').val(data.alca_fechfin);
       
        
    });
}

function eliminar(alca_id){
    swal.fire({
        title: "Eliminar!",
        text: "Desea Eliminar el Registro?",
        icon: "error",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.value) {
            $.post("../../controller/alcalde.php?op=eliminar",{alca_id : alca_id}, function (data) {
                $('#alcaldes_data').DataTable().ajax.reload();

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