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
        url:"../../controller/certificado.php?op=mostrar_certificado_propietario_completado",
        type:"post"
    },
    "bDestroy": true,
    "responsive": false,
    "bInfo":true,
    "iDisplayLength": 5,
    "order": [[ 0, "desc" ]],
    "scrollX": true, // Habilita barra de desplazamiento horizontal
    "scrollCollapse": true, // Colapsa el área de scroll si no es necesario 
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
    "columnDefs": [
        {
            "targets": -1, // Última columna (cuenta desde -1 para la última)
            "className": "dt-sticky-last", // Clase CSS para la columna fija
        }
    ]
});
