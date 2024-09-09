const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');


const image = new Image();

image.src = '../../public/titulo.jpg';
$(document).ready(function(){
    var cert_id = getUrlParameter('cert_id');
    $.post("../../controller/certificado.php?op=mostrar_certificado_detalle", { cert_id : cert_id }, function (data) {
        var data = JSON.parse(data);
        console.log(data);
        ctx.drawImage(image, 0, 0, canvas.width, canvas.height);

        /* Primer propietario */
        if (data.length > 0) {
            ctx.font = '9px Arial';
            ctx.fillText(data[0].prop_nombre + ' ' + data[0].prop_apep + ' ' + data[0].prop_apem, 500, 50);
            ctx.fillText(data[0].prop_estadocivil, 500, 100);
            ctx.fillText(data[0].prop_dni, 500, 150);
            ctx.fillText(data[0].prop_tipo, 500, 200);
            
        
        /* Segundo propietario (solo si hay más de un propietario) */
        if (data.length > 1) {
            ctx.font = '9px Arial';
            ctx.fillText(data[1].prop_nombre + ' ' + data[1].prop_apep + ' ' + data[1].prop_apem, 500, 250); // Cambia la posición vertical para no sobreponer
            ctx.fillText(data[1].prop_estadocivil, 500, 300);
            ctx.fillText(data[1].prop_dni, 500, 350);
            ctx.fillText(data[1].prop_tipo, 500, 400);
        }
    }
        
            /* Datos Certificado */
            ctx.fillText(data[0].cert_area, 500, 450);
            ctx.fillText(data[0].cert_perimetro, 500, 500);
            ctx.fillText(data[0].cert_ubicacion, 500, 550);
            ctx.fillText(data[0].cert_nompobl, 500, 600);
            ctx.fillText(data[0].cert_tipopobl, 500, 650);
            ctx.fillText(data[0].cert_uso, 500, 700);
            ctx.fillText(data[0].cert_frente, 500, 750);
            ctx.fillText(data[0].cert_derecha, 500, 800);
            ctx.fillText(data[0].cert_izquierda, 500, 850);
            ctx.fillText(data[0].cert_fondo, 500, 900);
            ctx.fillText(data[0].cert_manzana, 500, 950);
            ctx.fillText(data[0].cert_lote, 500, 1000);
            ctx.fillText(data[0].cert_distrito, 500, 1050);
            ctx.fillText(data[0].cert_provincia, 500, 1100);
            ctx.fillText(data[0].cert_departamento, 500, 1150);
            ctx.fillText(data[0].cert_numregdoc, 500, 1200);
            ctx.fillText(data[0].cert_numexpe, 500, 1250);
            ctx.fillText(data[0].cert_tecinf, 500, 1300);
            ctx.fillText(data[0].cert_numcert, 500, 1350);
            ctx.fillText(data[0].numactainsp, 500, 1400);
            ctx.fillText(data[0].insp_nombre + ' ' + data[0].insp_apep + ' ' + data[0].insp_apem, 500, 1450);
            ctx.fillText(data[0].insp_dni, 500, 1500);
    
            /* Datos Alcalde */
            ctx.fillText(data[0].alca_id, 500, 1550);
            ctx.fillText(data[0].alca_dni, 500, 1600);
            ctx.fillText(data[0].alca_nom + ' ' + data[0].alca_apep + ' ' + data[0].alca_apem, 500, 1650);
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