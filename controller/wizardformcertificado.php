<?php
    /*TODO: Llamando a cadena de Conexion */
    require_once("../config/conexion.php");
    /*TODO: Llamando a la clase */
    require_once("../models/Propietario.php");
    require_once("../models/Certificado.php");
    require_once("../models/Inspector.php");
    /*TODO: Inicializando Clase */
    $propietario = new Propietario();
    $certificado = new Certificado();
    $inspector = new Inspector();

    /*TODO: Opcion de solicitud de controller */
    switch($_GET["op"]){
         case "guardaryeditar":
            if(empty($_POST["prop_id"])){
                /* $propietario->insert_propietario($_POST["prop_nombre"],$_POST["prop_apep"],$_POST["prop_apem"],$_POST["prop_estadocivil"],$_POST["prop_dni"],$_POST["prop_tipo"],$_POST["prop_empadronamientos"]);
                $certificado->insert_certificado($_POST["insp_id"],$_POST["cert_area"],$_POST["cert_perimetro"],$_POST["cert_ubicacion"],$_POST["cert_nompobl"],$_POST["cert_tipopobl"],$_POST["cert_uso"],$_POST["cert_frente"],$_POST["cert_derecha"],$_POST["cert_izquierda"],$_POST["cert_fondo"],$_POST["cert_manzana"],$_POST["cert_lote"],$_POST["cert_distrito"],$_POST["cert_provincia"],$_POST["cert_departamento"],$_POST["cert_numregdoc"],$_POST["cert_numexpe"],$_POST["cert_tecinf"],$_POST["cert_numcert"],$_POST["cert_numactainsp"]);
                $inspector->insert_inspector($_POST["insp_nombre"],$_POST["insp_apep"],$_POST["insp_apem"],$_POST["insp_dni"]); */

                        $propietario->update_propietario($prop_ids[$i],$prop_tipos[$i],$prop_nombres[$i],$prop_apeps[$i],$prop_apems[$i], $prop_estadocivils[$i],$prop_dnis[$i],$prop_empadronamientos[$i]);
                        
                       
                            
                        
                    }
            
                
            
        

            break; 
        }