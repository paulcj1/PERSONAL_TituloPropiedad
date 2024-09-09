
function init(){
    $('#generate_report_certificado').on('click', function() {
        generar_reporte_certificado();
    });
    $('#generate_report_titulo').on('click', function() {
        generar_reporte_titulo();
    });
} 

$(document).ready(function() {
    // Inicializar los comboboxes
    combo_fecha_certificado();
    combo_completo_certificado();
    combo_urb_certificado();
    combo_fecha_titulo();
    combo_completo_titulo();
    combo_urb_titulo();

    // Inicializar las tablas
    $('#home_data_certificados').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "dom": 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
        "ajax": {
            "url": "../../controller/certificado.php?op=case",
            "type": "POST",
            "data": function (d) {
                d.fecha = $('#combo_fecha_certificado').val();
                d.completo = $('#combo_completo_certificado').val();
                d.urb = $('#combo_urb_certificado').val();
            },
           
            "error": function(xhr, status, error) {
                console.error('Error al cargar los datos:', status, error);
            }
        },
        "bDestroy": true,
        "responsive": false,
        "bInfo": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });

    $('#home_data_titulos').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "dom": 'Bfrtip',
        "buttons": [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
        "ajax": {
          "url": "../../controller/titulo.php?op=listar_resumen_titulo",
          "type": "POST",
          "data": function (d) {
            d.fecha = $('#combo_fecha_titulo').val();
            d.completo = $('#combo_completo_titulo').val();
            d.urb = $('#combo_urb_titulo').val();
          },
          "error": function(xhr, status, error) {
            console.error('Error al cargar los datos:', status, error);
          }
        },
        "bDestroy": true,
        "responsive": false,
        "bInfo": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]],
        "language": {
          "sProcessing": "Procesando...",
          "sLengthMenu": "Mostrar _MENU_ registros",
          "sZeroRecords": "No se encontraron resultados",
          "sEmptyTable": "Ningún dato disponible en esta tabla",
          "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
          "sSearch": "Buscar:",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
          },
          "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }
        }
      });
    
    
    // Event listener para los comboboxes de certificados
    $('#combo_fecha_certificado, #combo_completo_certificado, #combo_urb_certificado').change(function() {
        $('#home_data_certificados').DataTable().ajax.reload();
    });

    $('#combo_fecha_titulo, #combo_completo_titulo, #combo_urb_titulo').change(function() {
        $('#home_data_titulos').DataTable().ajax.reload();
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

    function combo_urb_certificado() {
        $.post("../../controller/certificado.php?op=combo_urb", function(data) {
            $('#combo_urb_certificado').html(data);
        });
    }

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

    function combo_urb_titulo() {
        $.post("../../controller/titulo.php?op=combo_urb", function(data) {
            $('#combo_urb_titulo').html(data);
        });
    }
});
// Funciones para llenar los comboboxes
function generar_reporte_certificado() {
    var params = {
        fecha: $('#combo_fecha_certificado').val(),
        completo: $('#combo_completo_certificado').val(),
        urb: $('#combo_urb_certificado').val()
    };
    redirect_by_post(
        "../../controller/certificado.php?op=generar_reporte",
        params,
        true
    );
}
function generar_reporte_titulo() {
    var params = {
        fecha: $('#combo_fecha_titulo').val(),
        completo: $('#combo_completo_titulo').val(),
        urb: $('#combo_urb_titulo').val()
    };
    redirect_by_post(
        "../../controller/titulo.php?op=generar_reporte",
        params,
        true
    );
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