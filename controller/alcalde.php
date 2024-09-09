<?php
    /*TODO: Llamando a cadena de Conexion */
    require_once("../config/conexion.php");
    /*TODO: Llamando a la clase */
    require_once("../models/Alcalde.php");
    
    /*TODO: Inicializando Clase */
    $alcalde = new Alcalde();

    /*TODO: Opcion de solicitud de controller */
    switch($_GET["op"]){
        case "guardaryeditar":
            if(empty($_POST["alca_id"])){
                $alcalde->insert_alcalde($_POST["alca_nom"],$_POST["alca_apep"],$_POST["alca_apem"],$_POST["alca_dni"],$_POST["alca_fechini"],$_POST["alca_fechfin"]);
            }else{
                $alcalde->update_alcalde($_POST["alca_id"],$_POST["alca_nom"],$_POST["alca_apep"],$_POST["alca_apem"],$_POST["alca_dni"],$_POST["alca_fechini"],$_POST["alca_fechfin"]);
                
            }
            break;
        case "alcalde_activo":
            $datos = $alcalde->get_alcalde_activo();
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output["alca_id"] = $row["alca_id"];
                    
                }
                echo json_encode($output);
                    }
                    break;
        case "listar":
            $datos=$alcalde->get_alcalde();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $alcalde_activo = ($row["alca_est"] == 1) ? '<div class="status-box active">Activo</div>'  // Recuadro para activo
                                                          : '<div class="status-box inactive">Inactivo</div>';  // Recuadro para inactivo
                
                $sub_array[] = $alcalde_activo;
                $sub_array[] = $row["alca_nom"] ." ". $row["alca_apep"] ." ". $row["alca_apem"];
                $sub_array[] = $row["alca_dni"];
                $sub_array[] = $row["alca_fechini"];
                $sub_array[] = $row["alca_fechfin"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["alca_id"].');"  id="'.$row["alca_id"].'" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["alca_id"].');"  id="'.$row["alca_id"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-trash"></i></div></button>';
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
                $datos = $alcalde->get_alcalde_id($_POST["alca_id"]);
                if(is_array($datos)==true and count($datos)<>0){
                    foreach($datos as $row){
                        $output["alca_id"] = $row["alca_id"];
                        $output["alca_nom"] = $row["alca_nom"];
                        $output["alca_apep"] = $row["alca_apep"];
                        $output["alca_apem"] = $row["alca_apem"];
                        $output["alca_dni"] = $row["alca_dni"];
                        $output["alca_fechini"] = $row["alca_fechini"];
                        $output["alca_fechfin"] = $row["alca_fechfin"];
                    }
                    echo json_encode($output);
                }
                break;

        case "alcalde_comprobar":
            $datos = $alcalde->alcalde_comprobar();
            echo json_encode($datos);
            break;
        case "alcalde_cambiarestado":
            $datos = $alcalde->alcalde_cambiarestado();
            echo json_encode($datos);
            break;  
    }