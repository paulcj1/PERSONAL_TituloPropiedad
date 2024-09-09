const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');


const image = new Image();

image.src = '../../public/titulo.jpg';

$(document).ready(function(){
    var titu_id = getUrlParameter('titu_id');
    
     $.post("../../controller/titulo.php?op=mostrar_titulo_detalle", { titu_id : titu_id }, function (data) {
        var data = JSON.parse(data);
        console.log(data);
        ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
        // Verificar si hay al menos un propietario
            if (data.length > 0) {
                /* Primer propietario */
                ctx.font = '9px Arial';
                ctx.fillText(data[0].prop_nombre + ' ' + data[0].prop_apep + ' ' + data[0].prop_apem, 500, 50);
                ctx.fillText(data[0].prop_estadocivil, 500, 100);
                ctx.fillText(data[0].prop_dni, 500, 150);
                ctx.fillText(data[0].prop_tipo, 500, 200);
            
            /* Verificar si hay un segundo propietario */
            if (data.length > 1) {
            /* Segundo Propietario */
            ctx.font = '9px Arial';
            ctx.fillText(data[1].prop_nombre + ' ' + data[1].prop_apep + ' ' + data[1].prop_apem, 500, 250); // Ajustar posición vertical
            ctx.fillText(data[1].prop_estadocivil, 500, 300);
            ctx.fillText(data[1].prop_dni, 500, 350);
            ctx.fillText(data[1].prop_tipo, 500, 400);
            }
                }
            
            /* Datos Titulo */
                ctx.font = '9px Arial';
                ctx.fillText(data[0].titu_partelec, 315, 185);
                ctx.fillText(data[0].titu_numtitulo, 500, 150);
                ctx.fillText(data[0].titu_partlote, 500, 200);
                ctx.fillText(data[0].titu_asiento, 500, 100);
                ctx.fillText(data[0].titu_serie, 500, 150);
                ctx.fillText(data[0].titu_tipo, 500, 200);
                ctx.fillText(data[0].titu_tazacion, 500, 100);
                ctx.fillText(data[0].titu_numresolucion, 500, 150);
                ctx.fillText(data[0].titu_fecharesolucion, 500, 200);
                ctx.fillText(data[0].titu_fechaemision, 500, 100);
                ctx.fillText(data[0].titu_fecharegistro, 500, 150);
            
            /* Datos Certificado */
                ctx.fillText(data[0].cert_id, 500, 200);
                ctx.fillText(data[0].cert_area, 500, 250); 
                ctx.fillText(data[0].cert_ubicacion, 500, 300);
                ctx.fillText(data[0].cert_nompobl, 500, 350);
                ctx.fillText(data[0].cert_tipopobl, 500, 400);
                ctx.fillText(data[0].cert_frente, 500, 450);
                ctx.fillText(data[0].cert_derecha, 500, 500);
                ctx.fillText(data[0].cert_izquierda, 500, 550);
                ctx.fillText(data[0].cert_fondo, 500, 600);
                ctx.fillText(data[0].cert_manzana, 500, 650);
                ctx.fillText(data[0].cert_lote, 500, 700);
                ctx.fillText(data[0].cert_distrito, 500, 750);
                ctx.fillText(data[0].cert_provincia, 500, 800);
                ctx.fillText(data[0].cert_departamento, 500, 850);
            
            /* Datos Alcalde */
                ctx.fillText(data[0].alca_id, 500, 900);
                ctx.fillText(data[0].alca_dni, 200, 300);
                ctx.fillText(data[0].alca_nom + ' ' + data[0].alca_apep + ' ' + data[0].alca_apem, 400, 200);
                });
            });
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}; 
