<?php
    /*TODO: Llamando a cadena de Conexion */
    require_once("../config/conexion.php");
    /*TODO: Llamando a la clase */
    require_once("../models/Propietario.php");
    /*TODO: Inicializando Clase */
    $propietario = new Propietario();

    /*TODO: Opcion de solicitud de controller */
    switch($_GET["op"]){
        case "guardaryeditar":
            if(empty($_POST["prop_id"])){
                $propietario->insert_propietario($_POST["prop_nombre"],$_POST["prop_apep"],$_POST["prop_apem"],$_POST["prop_estadocivil"],$_POST["prop_dni"],$_POST["prop_tipo"],$_POST["prop_empadronamientos"]);
            }else{
                $propietario->update_propietario($_POST["prop_id"],$_POST["prop_nombre"],$_POST["prop_apep"],$_POST["prop_apem"],$_POST["prop_estadocivil"],$_POST["prop_dni"],$_POST["prop_tipo"],$_POST["prop_empadronamientos"]);
            }
            break;
        case "mostrar":
            $datos = $propietario->get_propietario_id($_POST["prop_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output["prop_id"] = $row["prop_id"];
                    $output["prop_nombre"] = $row["prop_nombre"];
                    $output["prop_apep"] = $row["prop_apep"];
                    $output["prop_apem"] = $row["prop_apem"];
                    $output["prop_estadocivil"] = $row["prop_estadocivil"];
                    $output["prop_dni"] = $row["prop_dni"];
                    $output["prop_tipo"] = $row["prop_tipo"];
                }
                echo json_encode($output);
            }
            break;
        case "eliminar":
            $propietario->delete_propietario($_POST["prop_id"]);
            break;
        
        case "listar":
                    $datos=$propietario->get_propietario();
                    $data= Array();
                    foreach($datos as $row){
                        $sub_array = array();
                        $sub_array[] = $row["prop_id"];
                        $sub_array[] = $row["prop_nombre"] ." ". $row["prop_apep"] ." ". $row["prop_apem"];
                        $sub_array[] = $row["prop_estadocivil"];
                        $sub_array[] = $row["prop_dni"];
                        $sub_array[] = $row["prop_tipo"];
                        $sub_array[] = '<button type="button" onClick="editar('.$row["prop_id"].');"  id="'.$row["prop_id"].'" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>';
                        $sub_array[] = '<button type="button" onClick="eliminar('.$row["prop_id"].');"  id="'.$row["prop_id"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-trash"></i></div></button>';
                        $data[] = $sub_array;
                    }

                    $results = array(
                        "sEcho"=>1,
                        "iTotalRecords"=>count($data),
                        "iTotalDisplayRecords"=>count($data),
                        "aaData"=>$data);
                    echo json_encode($results);
                    break;
        
        case "mostrar_editar_modal":
            $datos = $propietario->get_propietario_x_id_certificado($_POST["cert_id"]);
                if(is_array($datos)==true and count($datos)<>0){
                    foreach($datos as $row){
                        $output[] = [
                        "prop_id" => $row["prop_id"],
                        "prop_nombre" => $row["prop_nombre"],
                        "prop_apep" => $row["prop_apep"],
                        "prop_apem" => $row["prop_apem"],
                        "prop_estadocivil" => $row["prop_estadocivil"],
                        "prop_dni" => $row["prop_dni"],
                        "prop_tipo" => $row["prop_tipo"]];
                    }
                    echo json_encode($output);
                }
                break;
        case "mostrar_propietarios_x_idtitulo":
            $datos = $propietario->get_propietario_x_id_titulo($_POST["titu_id"]);
                if(is_array($datos)==true and count($datos)<>0){
                    foreach($datos as $row){
                        $output[] = [
                        "prop_id" => $row["prop_id"],
                        "prop_nombre" => $row["prop_nombre"],
                        "prop_apep" => $row["prop_apep"],
                        "prop_apem" => $row["prop_apem"],
                        "prop_estadocivil" => $row["prop_estadocivil"],
                        "prop_dni" => $row["prop_dni"],
                        "prop_tipo" => $row["prop_tipo"]];
                    }
                    echo json_encode($output);
                }
                break;
        
                  
                }