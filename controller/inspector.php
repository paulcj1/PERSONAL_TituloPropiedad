<?php
    /*TODO: Llamando a cadena de Conexion */
    require_once("../config/conexion.php");
    /*TODO: Llamando a la clase */
    require_once("../models/Inspector.php");
    
    /*TODO: Inicializando Clase */
    $inspector = new Inspector();

    /*TODO: Opcion de solicitud de controller */
    switch($_GET["op"]){
        case "guardaryeditar":
            if(empty($_POST["insp_id"])){
                $inspector->insert_inspector($_POST["insp_nombre"],$_POST["insp_apep"],$_POST["insp_apem"],$_POST["insp_dni"]);
            }else{
                $inspector->update_inspector($_POST["insp_id"],$_POST["insp_nombre"],$_POST["insp_apep"],$_POST["insp_apem"],$_POST["insp_dni"]);
                
            }
            break;
        case "listar":
                    $datos=$inspector->get_inspector();
                    $data= Array();
                    foreach($datos as $row){
                        $sub_array = array();
                        $sub_array[] = $row["insp_id"];
                        $sub_array[] = $row["insp_nombre"] ." ". $row["insp_apep"] ." ". $row["insp_apem"];
                        $sub_array[] = $row["insp_dni"];
                        $sub_array[] = '<button type="button" onClick="editar('.$row["insp_id"].');"  id="'.$row["insp_id"].'" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>';
                        $sub_array[] = '<button type="button" onClick="eliminar('.$row["insp_id"].');"  id="'.$row["insp_id"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-trash"></i></div></button>';
                        $data[] = $sub_array;
                    }

                    $results = array(
                        "sEcho"=>1,
                        "iTotalRecords"=>count($data),
                        "iTotalDisplayRecords"=>count($data),
                        "aaData"=>$data);
                    echo json_encode($results);
                    break;
        
        /*TODO: Creando Json segun el ID */
        case "mostrar":
                $datos = $inspector->get_inspector_id($_POST["insp_id"]);
                if(is_array($datos)==true and count($datos)<>0){
                    foreach($datos as $row){
                        $output["insp_id"] = $row["insp_id"];
                        $output["insp_nombre"] = $row["insp_nombre"];
                        $output["insp_apep"] = $row["insp_apep"];
                        $output["insp_apem"] = $row["insp_apem"];
                        $output["insp_dni"] = $row["insp_dni"];
                    }
                    echo json_encode($output);
                }
                break;
        case "editar_modal_inspector":
            $datos = $inspector->get_inspector_x_id_certificado($_POST["cert_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output["insp_id"] = $row["insp_id"];
                    $output["insp_nombre"] = $row["insp_nombre"];
                    $output["insp_apep"] = $row["insp_apep"];
                    $output["insp_apem"] = $row["insp_apem"];
                    $output["insp_dni"] = $row["insp_dni"];
                }
                echo json_encode($output);
                    }
                    break;
        case "combo":
            $datos=$inspector->get_inspector();
            if(is_array($datos)==true and count($datos)>0){
                $html= " <option label='Seleccione'></option>";
                foreach($datos as $row){
                    $nombre_completo = $row['insp_nombre'] . " " . $row['insp_apep'] . " " . $row['insp_apem'];
                    $html .= "<option value='" . $row['insp_id'] . "'>" . $nombre_completo . "</option>";
                }
                echo $html;
            }
            break;
                
        case "eliminar":
            $inspector->delete_inspector($_POST["insp_id"]);
            break;
            
            }
                