<?php

    
    require_once("../public/plantilla_reporte.php");
  
    /*TODO: Llamando a cadena de Conexion */
    require_once("../config/conexion.php");
    /*TODO: Llamando a la clase */
    require_once("../models/Propietario.php");
    require_once("../models/Certificado.php");
   
    
    /*TODO: Inicializando Clase */
   
    $propietario = new Propietario();
    $certificado = new Certificado();
    
    
    /*TODO: Opcion de solicitud de controller */
    switch($_GET["op"]){

        
        case "guardaryeditar":
            if (empty($_POST["cert_id"])) { 
                // Código para guardar un nuevo certificado
                $propietarios = $_POST['propietarios'];
                $prop_id_array = [];
                
                // Insertar el nuevo certificado y obtener su ID
                $cert_id = $certificado->insert_certificado(
                    $_POST["insp_id"], $_POST["tivi_id"], $_POST["tiur_id"], $_POST["cert_area"], 
                    $_POST["cert_perimetro"], $_POST["cert_uso"], $_POST["cert_frente"], $_POST["cert_derecha"], 
                    $_POST["cert_izquierda"], $_POST["cert_fondo"], $_POST["cert_medfrente"], $_POST["cert_medderecha"], 
                    $_POST["cert_medizquierda"], $_POST["cert_medfondo"], $_POST["cert_manzana"], $_POST["cert_lote"], 
                    $_POST["cert_etapa"], $_POST["cert_numregdoc"], $_POST["cert_tecinf"], $_POST["cert_numactainsp"], 
                    $_POST["cert_nomtipourb"], $_POST["cert_nomtipovia"], $_POST["cert_numrecibo_derinsp"]
                );
        
                // Guardar los propietarios y obtener sus IDs
                foreach ($propietarios as $propi) {
                    $prop_nombre = $propi['prop_nombre'];
                    $prop_apep = $propi['prop_apep'];
                    $prop_apem = $propi['prop_apem'];
                    $prop_estadocivil = $propi['prop_estadocivil'];
                    $prop_dni = $propi['prop_dni'];
                    $prop_tipo = $propi['prop_tipo'];
                
                    // Insertar el nuevo propietario y guardar su ID
                    $prop_id = $propietario->insert_propietario($prop_nombre, $prop_apep, $prop_apem, $prop_estadocivil, $prop_dni, $prop_tipo);
                    $prop_id_array[] = $prop_id;
                }
        
                // Enlazar los propietarios con el certificado
                foreach ($prop_id_array as $prop_id) {
                    $certificado->insert_certificado_propietario($cert_id, $prop_id);
                }
                
            } else {
                // Código para editar un certificado existente
                $propietarios = $_POST['propietarios'];
                $prop_id_array = [];
                $current_prop_ids = [];
                
                // Obtener los propietarios actuales del certificado
                $current_propietarios = $certificado->get_propietarios_by_certificado($_POST["cert_id"]);
                
                // Crear un array con los IDs actuales de los propietarios
                foreach ($current_propietarios as $current_propi) {
                    $current_prop_ids[] = $current_propi['prop_id'];
                }
                
                // Recorrer la nueva lista de propietarios
                foreach ($propietarios as $propi) {
                    $prop_id = $propi['prop_id'];
                    $prop_nombre = $propi['prop_nombre'];
                    $prop_apep = $propi['prop_apep'];
                    $prop_apem = $propi['prop_apem'];
                    $prop_estadocivil = $propi['prop_estadocivil'];
                    $prop_dni = $propi['prop_dni'];
                    $prop_tipo = $propi['prop_tipo'];
                
                    if (empty($prop_id)) {
                        // Si prop_id está vacío, es un nuevo propietario
                        $prop_id = $propietario->insert_propietario($prop_nombre, $prop_apep, $prop_apem, $prop_estadocivil, $prop_dni, $prop_tipo);
                        $prop_id_array[] = $prop_id;
                    } else {
                        // Si prop_id tiene valor, es un propietario existente
                        if (in_array($prop_id, $current_prop_ids)) {
                            $propietario->update_propietario($prop_id, $prop_nombre, $prop_apep, $prop_apem, $prop_estadocivil, $prop_dni, $prop_tipo);
                            $current_prop_ids = array_diff($current_prop_ids, [$prop_id]);
                        } else {
                            // Propietario existente que no estaba en la lista original
                            $prop_id_array[] = $prop_id;
                        }
                    }
                }
                
                // Eliminar los propietarios que no están en la nueva lista
                foreach ($current_prop_ids as $prop_id) {
                    $certificado->delete_certificado_propietario($_POST["cert_id"], $prop_id);
                }
                
                // Actualizar el certificado existente
                $certificado->update_certificado(
                    $_POST["cert_id"], $_POST["insp_id"], $_POST["tivi_id"], $_POST["tiur_id"], $_POST["cert_area"], 
                    $_POST["cert_perimetro"], $_POST["cert_uso"], $_POST["cert_frente"], $_POST["cert_derecha"], 
                    $_POST["cert_izquierda"], $_POST["cert_fondo"], $_POST["cert_medfrente"], $_POST["cert_medderecha"], 
                    $_POST["cert_medizquierda"], $_POST["cert_medfondo"], $_POST["cert_manzana"], $_POST["cert_lote"], 
                    $_POST["cert_etapa"], $_POST["cert_numregdoc"], $_POST["cert_tecinf"], $_POST["cert_numactainsp"], 
                    $_POST["cert_nomtipourb"], $_POST["cert_nomtipovia"], $_POST["cert_numrecibo_derinsp"]
                );
                
                // Enlazar los propietarios con el certificado
                foreach ($prop_id_array as $prop_id) {
                    if (!in_array($prop_id, $current_prop_ids)) { // Evitar duplicar la inserción
                        $certificado->insert_certificado_propietario($_POST["cert_id"], $prop_id);
                    }
                }
            }
            break;
 
        case "mostrar":
            $datos = $certificado->get_certificado_id($_POST["cert_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output["cert_id"] = $row["cert_id"];
                    $output["insp_id"] = $row["insp_id"];
                    $output["cert_area"] = $row["cert_area"];
                    $output["cert_perimetro"] = $row["cert_perimetro"];
                    $output["cert_ubicacion"] = $row["cert_ubicacion"];
                    $output["cert_nompobl"] = $row["cert_nompobl"];
                    $output["cert_tipopobl"] = $row["cert_tipopobl"];
                    $output["cert_uso"] = $row["cert_uso"];
                    $output["cert_frente"] = $row["cert_frente"];
                    $output["cert_derecha"] = $row["cert_derecha"];
                    $output["cert_izquierda"] = $row["cert_izquierda"];
                    $output["cert_fondo"] = $row["cert_fondo"];
                    $output["cert_manzana"] = $row["cert_manzana"];
                    $output["cert_lote"] = $row["cert_lote"];
                    $output["cert_distrito"] = $row["cert_distrito"];
                    $output["cert_provincia"] = $row["cert_provincia"];
                    $output["cert_departamento"] = $row["cert_departamento"];
                    $output["cert_numregdoc"] = $row["cert_numregdoc"];
                    $output["cert_numexpe"] = $row["cert_numexpe"];
                    $output["cert_tecinf"] = $row["cert_tecinf"];
                    $output["cert_numcert"] = $row["cert_numcert"];
                    $output["cert_numactainsp"] = $row["cert_numactainsp"];
                }
                echo json_encode($output);
            }
            break;
        case "editar_modal_certificado":
            $datos = $certificado->get_certificado_id($_POST["cert_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output["cert_id"] = $row["cert_id"];
                    $output["insp_id"] = $row["insp_id"];
                    $output["tiur_id"] = $row["tiur_id"];
                    $output["cert_nomtipourb"] = $row["cert_nomtipourb"];
                    $output["tivi_id"] = $row["tivi_id"];
                    $output["cert_nomtipovia"] = $row["cert_nomtipovia"];
                    $output["cert_numrecibo_derinsp"] = $row["cert_numrecibo_derinsp"];
                    $output["cert_area"] = $row["cert_area"];
                    $output["cert_perimetro"] = $row["cert_perimetro"];
                    $output["cert_uso"] = $row["cert_uso"];
                    $output["cert_frente"] = $row["cert_frente"];
                    $output["cert_derecha"] = $row["cert_derecha"];
                    $output["cert_izquierda"] = $row["cert_izquierda"];
                    $output["cert_fondo"] = $row["cert_fondo"];
                    $output["cert_medfrente"] = $row["cert_medfrente"]; 
                    $output["cert_medderecha"] = $row["cert_medderecha"];
                    $output["cert_medizquierda"] = $row["cert_medizquierda"];
                    $output["cert_medfondo"] = $row["cert_medfondo"];
                    $output["cert_manzana"] = $row["cert_manzana"];
                    $output["cert_lote"] = $row["cert_lote"];
                    $output["cert_etapa"] = $row["cert_etapa"];
                    $output["cert_numregdoc"] = $row["cert_numregdoc"];
                    $output["cert_numexpe"] = $row["cert_numexpe"];
                    $output["cert_tecinf"] = $row["cert_tecinf"];
                    $output["cert_numcert"] = $row["cert_numcert"];
                    $output["cert_numactainsp"] = $row["cert_numactainsp"];
                }
                echo json_encode($output);
            }
            break;
        case "mostrar_editar_modal_prueba":
            $datos = $certificado->get_certificado_propietario_x_id($_POST["cert_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    
                    $output["prop_id"] = $row["prop_id"];
                    $output["prop_nombre"] = $row["prop_nombre"];
                    $output["prop_apep"] = $row["prop_apep"];
                    $output["prop_apem"] = $row["prop_apem"];
                    $output["prop_estadocivil"] = $row["prop_estadocivil"];
                    $output["prop_dni"] = $row["prop_dni"];
                    $output["prop_tipo"] = $row["prop_tipo"];
                    $output["prop_empadronamientos"] = $row["prop_empadronamientos"];
                    $output["cert_id"] = $row["cert_id"];
                    $output["cert_area"] = $row["cert_area"];
                    $output["cert_perimetro"] = $row["cert_perimetro"];
                    $output["cert_ubicacion"] = $row["cert_ubicacion"];
                    $output["cert_nompobl"] = $row["cert_nompobl"];
                    $output["cert_tipopobl"] = $row["cert_tipopobl"];
                    $output["cert_uso"] = $row["cert_uso"];
                    $output["cert_frente"] = $row["cert_frente"];
                    $output["cert_derecha"] = $row["cert_derecha"];
                    $output["cert_izquierda"] = $row["cert_izquierda"];
                    $output["cert_fondo"] = $row["cert_fondo"];
                    $output["cert_manzana"] = $row["cert_manzana"];
                    $output["cert_lote"] = $row["cert_lote"];
                    $output["cert_distrito"] = $row["cert_distrito"];
                    $output["cert_provincia"] = $row["cert_provincia"];
                    $output["cert_departamento"] = $row["cert_departamento"];
                    $output["cert_numregdoc"] = $row["cert_numregdoc"];
                    $output["cert_numexpe"] = $row["cert_numexpe"];
                    $output["cert_tecinf"] = $row["cert_tecinf"];
                    $output["cert_numcert"] = $row["cert_numcert"];
                    $output["cert_numactainsp"] = $row["cert_numactainsp"];
                    $output["insp_id"] = $row["insp_id"];
                    $output["insp_nombre"] = $row["insp_nombre"];
                    $output["insp_apep"] = $row["insp_apep"];
                    $output["insp_apem"] = $row["insp_apem"];
                    $output["insp_dni"] = $row["insp_dni"];
                    $output["dist_id"] = $row["dist_id"];
                    $output["dist_nom"] = $row["dist_nom"];
                    $output["cepr_id"] = $row["cepr_id"];
                }
                echo json_encode($output);
            }
            break;
        case "mostrar_editar_modal":
            $datos = $certificado->get_certificado_propietario_x_id($_POST["cert_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    
                    $output["prop_id"] = $row["prop_id"];
                    $output["prop_nombre"] = $row["prop_nombre"];
                    $output["prop_apep"] = $row["prop_apep"];
                    $output["prop_apem"] = $row["prop_apem"];
                    $output["prop_estadocivil"] = $row["prop_estadocivil"];
                    $output["prop_dni"] = $row["prop_dni"];
                    $output["prop_tipo"] = $row["prop_tipo"];
                    $output["prop_empadronamientos"] = $row["prop_empadronamientos"];
                    $output["cert_id"] = $row["cert_id"];
                    $output["cert_area"] = $row["cert_area"];
                    $output["cert_perimetro"] = $row["cert_perimetro"];
                    $output["cert_ubicacion"] = $row["cert_ubicacion"];
                    $output["cert_nompobl"] = $row["cert_nompobl"];
                    $output["cert_tipopobl"] = $row["cert_tipopobl"];
                    $output["cert_uso"] = $row["cert_uso"];
                    $output["cert_frente"] = $row["cert_frente"];
                    $output["cert_derecha"] = $row["cert_derecha"];
                    $output["cert_izquierda"] = $row["cert_izquierda"];
                    $output["cert_fondo"] = $row["cert_fondo"];
                    $output["cert_medfrente"] = $row["cert_medfrente"]; 
                    $output["cert_medderecha"] = $row["cert_medderecha"];
                    $output["cert_medizquierda"] = $row["cert_medizquierda"];
                    $output["cert_medfondo"] = $row["cert_medfondo"];
                    $output["cert_manzana"] = $row["cert_manzana"];
                    $output["cert_lote"] = $row["cert_lote"];
                    $output["cert_distrito"] = $row["cert_distrito"];
                    $output["cert_provincia"] = $row["cert_provincia"];
                    $output["cert_departamento"] = $row["cert_departamento"];
                    $output["cert_numregdoc"] = $row["cert_numregdoc"];
                    $output["cert_numexpe"] = $row["cert_numexpe"];
                    $output["cert_tecinf"] = $row["cert_tecinf"];
                    $output["cert_numcert"] = $row["cert_numcert"];
                    $output["cert_numactainsp"] = $row["cert_numactainsp"];
                    $output["insp_id"] = $row["insp_id"];
                    $output["insp_nombre"] = $row["insp_nombre"];
                    $output["insp_apep"] = $row["insp_apep"];
                    $output["insp_apem"] = $row["insp_apem"];
                    $output["insp_dni"] = $row["insp_dni"];
                    $output["dist_id"] = $row["dist_id"];
                    $output["dist_nom"] = $row["dist_nom"];
                    $output["cepr_id"] = $row["cepr_id"];
                }
                echo json_encode($output);
            }
            break;
        case "mostrar_editar_modal_array":
            $datos = $certificado->get_certificado_propietario_x_id($_POST["cert_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output[] = [
                    "prop_id" => $row["prop_id"],
                    "prop_nombre" => $row["prop_nombre"],
                    "prop_apep" => $row["prop_apep"],
                    "prop_apem" => $row["prop_apem"],
                    "prop_estadocivil" => $row["prop_estadocivil"],
                    "prop_dni" => $row["prop_dni"],
                    "prop_tipo" => $row["prop_tipo"],
                    "prop_empadronamientos" => $row["prop_empadronamientos"],
                    "cert_id" => $row["cert_id"],
                    "cert_area" => $row["cert_area"],
                    "cert_perimetro" => $row["cert_perimetro"],
                    "cert_ubicacion" => $row["cert_ubicacion"],
                    "cert_nompobl" => $row["cert_nompobl"],
                    "cert_tipopobl" => $row["cert_tipopobl"],
                    "cert_uso" => $row["cert_uso"],
                    "cert_frente" => $row["cert_frente"],
                    "cert_derecha" => $row["cert_derecha"],
                    "cert_izquierda" => $row["cert_izquierda"],
                    "cert_fondo" => $row["cert_fondo"],
                    "cert_manzana" => $row["cert_manzana"],
                    "cert_lote" => $row["cert_lote"],
                    "cert_distrito" => $row["cert_distrito"],
                    "cert_provincia" => $row["cert_provincia"],
                    "cert_departamento" => $row["cert_departamento"],
                    "cert_numregdoc" => $row["cert_numregdoc"],
                    "cert_numexpe" => $row["cert_numexpe"],
                    "cert_tecinf" => $row["cert_tecinf"],
                    "cert_numcert" => $row["cert_numcert"],
                    "cert_numactainsp" => $row["cert_numactainsp"],
                    "insp_id" => $row["insp_id"],
                    "insp_nombre" => $row["insp_nombre"],
                    "insp_apep" => $row["insp_apep"],
                    "insp_apem" => $row["insp_apem"],
                    "insp_dni" => $row["insp_dni"],
                    "dist_id" => $row["dist_id"],
                    "dist_nom" => $row["dist_nom"]];
                }
                echo json_encode($output);
            }
            break;
        case "listar_resumen_certificado":
                    $datos=$certificado->get_certificado();
                    $data= Array();
                    foreach($datos as $row){
                        $sub_array = array();
                        $sub_array[] = $row["datospropietarios"];
                        $sub_array[] = $row["cert_area"];
                        $sub_array[] = $row["cert_perimetro"];
                        $sub_array[] = $row["tivi_abr"] ." ". $row["cert_nomtipovia"] ." , ". $row["cert_manzana"] ." , ". $row["cert_lote"] ." , ". $row["tiur_abr"] ." ". $row["cert_nomtipourb"];
                        $sub_array[] = $row["cert_uso"];
                        $sub_array[] = $row["cert_numregdoc"];
                        $sub_array[] = $row["cert_numexpe"];
                        $sub_array[] = $row["cert_tecinf"];
                        $sub_array[] = $row["cert_numcert"];
                        $sub_array[] = $row["cert_numactainsp"];
                        $sub_array[] = $row["insp_nombre"] ." , ". $row["insp_apep"] ." , ".$row["insp_apem"];
                        $sub_array[] = $row["insp_dni"];
                        $data[] = $sub_array;
                    }

                    $results = array(
                        "sEcho"=>1,
                        "iTotalRecords"=>count($data),
                        "iTotalDisplayRecords"=>count($data),
                        "aaData"=>$data);
                    echo json_encode($results);
                    break;
        case "mostrar_certificado_propietario":
            $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
            $completo = isset($_POST['completo']) ? $_POST['completo'] : '';
            $datos = $certificado->get_certificado_detalle($fecha, $completo);  
            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();

                
                
            
                // Obtener los datos
                
                $highlight_class = ($row["cert_estfirma"] == 3) ? 'highlight-row' : '';
                
                $impreso = ($row["cert_estimp"] == 0) ? '' : '<span class="status-box status-imp">I</span>';
                $titulado = ($row["cert_esttitu"] == 0) ? '' : '<span class="status-box status-titulo">T</span>';
                $completo = ($row["cert_est"] == 0) ? '' : '<span class="status-box status-completo">C</span>';
                


                $adjunto_symbol = ($row["cert_estadj"] == 0) ? '' : '<a href="#" class="fa fa-file-upload file-upload-icon" onclick="vistaprevia(' . $row["cert_id"] . ')"></a>';

                $validar_editar = ($row["cert_estfirma"] == 0) ? '<a href="#" class="btn btn-slateblue" onclick="editar(' . $row["cert_id"] . ')">Editar</a>' : '';
                $validar_eliminar = ($row["cert_estfirma"] == 0) ? '<a href="#" class="btn btn-red" onclick="eliminar(' . $row["cert_id"] . ')">Eliminar</a>' : ''; 

                $validar_titulacion_firmado = ($row["cert_estfirma"] == 3) ? '<a href="#" class="btn btn-yellowgreen" onclick="titulo(' . $row["cert_id"] . ')">Titulacion</a>' : '';
                $validar_titulacion_entregado = ($row["cert_estent"] == 1) ? $validar_titulacion_firmado : '';
                $validar_titulacion = ($row["cert_esttitu"] == 0) ? $validar_titulacion_entregado : ''; 

                $validar_entrega_firma = ($row["cert_estfirma"] == 3) ? '<button class="btn btn-success" style="background-color: blue; border-color: blue;" onclick="entregar(' . $row["cert_id"] . ')">Entregar</button>' : '';
                $validar_entrega_estimp = ($row["cert_estimp"] == 1) ?  $validar_entrega_firma : '';
                $validar_entrega = ($row["cert_estent"] == 0) ? $validar_entrega_estimp : '<button class="btn btn-success" disabled style="background-color: gray; border-color: gray;">Entregado</button>';

                $validar_firmar_incompleto = ($row["cert_estfirma"] == 0) ? '<button class="btn btn-success" style="background-color: blue; border-color: blue;" onclick="firmar(' . $row["cert_id"] . ')">Firmar</button>' :  '';
                $validar_firmar_adj = ($row["cert_estadj"] == 0) ? '' : $validar_firmar_incompleto;

                $validar_adjuntar_estimp = ($row["cert_estimp"] == 1) ? '<a href="#" class="btn btn-darkblue" onclick="adjuntar(' . $row["cert_id"] . ')">Adjuntar</a>' : '';
                $validar_adjuntar_completo = ($row["cert_est"] == 0) ? $validar_adjuntar_estimp : '';
                
                $validar_generar_completo = ($row["cert_est"] == 0) ? '<a href="#" class="btn btn-brown" class="nav-link" onclick="generar(' . $row["cert_id"] . ')">Generar</a>' : '<a href="#" class="btn btn-brown" class="nav-link" onclick="abrir(' . $row["cert_id"] . ')">Generar</a>';
                
        
                $sub_array[] = $impreso. $titulado . $completo;
                $sub_array[] = $row["datospropietarios"];
                $sub_array[] = $row["cert_area"];
                $sub_array[] = $row["cert_perimetro"];
                $sub_array[] = $row["tivi_abr"] ." ". $row["cert_nomtipovia"] ." , ". $row["cert_manzana"] ." , ". $row["cert_lote"] ." , ". $row["tiur_abr"] ." ". $row["cert_nomtipourb"];
                $sub_array[] = $row["cert_uso"];
                $sub_array[] = $row["cert_numregdoc"];
                $sub_array[] = $row["cert_numexpe"];
                $sub_array[] = $row["cert_tecinf"];
                $sub_array[] = $row["cert_numcert"];
                $sub_array[] = $row["cert_numactainsp"];
                $sub_array[] = $row["insp_nombre"] ." , ". $row["insp_apep"] ." , ".$row["insp_apem"];
                $sub_array[] = $row["insp_dni"];
                $sub_array[] = $validar_entrega . $validar_firmar_adj;
                $sub_array[] = '
                    <td class="dropdown hidden-xs-down show">
                        <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info" aria-expanded="true"><i class="icon ion-more"></i></a>
                        <div class="dropdown-menu dropdown-menu-left pd-10">
                            <nav class="nav nav-style-1 flex-column">
                                ' . $validar_editar . '
                                ' . $validar_eliminar . '
                                ' . $validar_generar_completo . '
                                ' . $validar_titulacion . '
                                ' . $validar_adjuntar_completo . '
                            </nav>
                        </div><!-- dropdown-menu -->
                    </td>';
                $sub_array[] = $adjunto_symbol;
                $sub_array['DT_RowClass'] = $highlight_class; // Add this line
                $data[] = $sub_array;
            }
        
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);
            break;
        case "listar_certificados_pendiente_subgerente":
            $datos=$certificado->get_certificado_detalle_subgerente_pendiente();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $impreso = ($row["cert_estimp"] == 0) ? '' : '<span class="status-box status-imp">I</span>';
                $adjunto_symbol = ($row["cert_estadj"] == 0) ? '' : '<a href="#" class="fa fa-file-upload file-upload-icon" onclick="vistaprevia(' . $row["cert_id"] . ')"></a>';

                $validar_adjuntar_estimp = ($row["cert_estimp"] == 1) ? '<a href="#" class="btn btn-darkblue" class="nav-link" onclick="adjuntar(' . $row["cert_id"] . ')">Adjuntar</a>' :  '';
                $validar_firmar = ($row["cert_estfirma"] == 1) ? '<button class="btn btn-success" style="background-color: blue; border-color: blue;" onclick="firmar(' . $row["cert_id"] . ')">Firmar</button>': '';
                $validar_firmar_adj = ($row["cert_estadj"] == 0) ? '': $validar_firmar;
        
                $sub_array[] = $impreso;
                $sub_array[] = $row["datospropietarios"];
                $sub_array[] = $row["cert_area"];
                $sub_array[] = $row["cert_perimetro"];
                $sub_array[] = $row["tivi_abr"] ." ". $row["cert_nomtipovia"] ." , ". $row["cert_manzana"] ." , ". $row["cert_lote"] ." , ". $row["tiur_abr"] ." ". $row["cert_nomtipourb"];
                $sub_array[] = $row["cert_uso"];
                $sub_array[] = $row["cert_numregdoc"];
                $sub_array[] = $row["cert_numexpe"];
                $sub_array[] = $row["cert_tecinf"];
                $sub_array[] = $row["cert_numcert"];
                $sub_array[] = $row["cert_numactainsp"];
                $sub_array[] = $row["insp_nombre"] ." , ". $row["insp_apep"] ." , ".$row["insp_apem"];
                $sub_array[] = $row["insp_dni"];
                $sub_array[] = $validar_firmar_adj;
                $sub_array[] = '
                    <td class="dropdown hidden-xs-down show">
                        <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info" aria-expanded="true"><i class="icon ion-more"></i></a>
                        <div class="dropdown-menu dropdown-menu-left pd-10">
                            <nav class="nav nav-style-1 flex-column">
                                <a href="#" class="btn btn-brown" class="nav-link" onclick="abrir(' . $row["cert_id"] . ')">Generar</a>
                                ' . $validar_adjuntar_estimp . '
                            </nav>
                        </div><!-- dropdown-menu -->
                    </td>';
                $sub_array[] = $adjunto_symbol;
                $data[] = $sub_array;
            }
        
            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
        case "listar_certificados_pendiente_gerente":
            $datos=$certificado->get_certificado_detalle_gerente_pendiente();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
        
                $impreso = ($row["cert_estimp"] == 0) ? '' : '<span class="status-box status-imp">I</span>';
                $adjunto_symbol = ($row["cert_estadj"] == 0) ? '' : '<a href="#" class="fa fa-file-upload file-upload-icon" onclick="vistaprevia(' . $row["cert_id"] . ')"></a>';


                $validar_adjuntar_estimp = ($row["cert_estimp"] == 1) ? '<a href="#" class="btn btn-darkblue" class="nav-link" onclick="adjuntar(' . $row["cert_id"] . ')">Adjuntar</a>' :  '';
                $validar_firmar = ($row["cert_estfirma"] == 2) ? '<button class="btn btn-success" style="background-color: blue; border-color: blue;" onclick="firmar(' . $row["cert_id"] . ')">Firmar</button>': '';
                $validar_firmar_adj = ($row["cert_estadj"] == 0) ? '': $validar_firmar;


        
                $sub_array[] = $impreso;
                $sub_array[] = $row["datospropietarios"];
                $sub_array[] = $row["cert_area"];
                $sub_array[] = $row["cert_perimetro"];
                $sub_array[] = $row["tivi_abr"] ." ". $row["cert_nomtipovia"] ." , ". $row["cert_manzana"] ." , ". $row["cert_lote"] ." , ". $row["tiur_abr"] ." ". $row["cert_nomtipourb"];
                $sub_array[] = $row["cert_uso"];
                $sub_array[] = $row["cert_numregdoc"];
                $sub_array[] = $row["cert_numexpe"];
                $sub_array[] = $row["cert_tecinf"];
                $sub_array[] = $row["cert_numcert"];
                $sub_array[] = $row["cert_numactainsp"];
                $sub_array[] = $row["insp_nombre"] ." , ". $row["insp_apep"] ." , ".$row["insp_apem"];
                $sub_array[] = $row["insp_dni"];
                $sub_array[] = $validar_firmar_adj;
                $sub_array[] = '
                    <td class="dropdown hidden-xs-down show">
                        <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info" aria-expanded="true"><i class="icon ion-more"></i></a>
                        <div class="dropdown-menu dropdown-menu-left pd-10">
                            <nav class="nav nav-style-1 flex-column">
                                <a href="#" class="btn btn-brown" class="nav-link" onclick="abrir(' . $row["cert_id"] . ')">Generar</a>
                                ' . $validar_adjuntar_estimp . '
                            </nav>
                        </div><!-- dropdown-menu -->
                    </td>';
                $sub_array[] = $adjunto_symbol;
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
        case "mostrar_certificado_propietario_completado":
            $datos=$certificado->get_certificado_detalle_completado();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["datospropietarios"];
                $sub_array[] = $row["cert_area"];
                $sub_array[] = $row["cert_perimetro"];
                $sub_array[] = $row["cert_distrito"] ." , ". $row["cert_ubicacion"] ." , ". $row["cert_manzana"] ." , ". $row["cert_lote"] ." , ". $row["cert_tipopobl"] ." ". $row["cert_nompobl"];
                $sub_array[] = $row["cert_uso"];
                $sub_array[] = $row["cert_frente"];
                $sub_array[] = $row["cert_derecha"];
                $sub_array[] = $row["cert_izquierda"];
                $sub_array[] = $row["cert_fondo"];
                $sub_array[] = $row["cert_numregdoc"];
                $sub_array[] = $row["cert_numexpe"];
                $sub_array[] = $row["cert_tecinf"];
                $sub_array[] = $row["cert_numcert"];
                $sub_array[] = $row["cert_numactainsp"];
                $sub_array[] = $row["insp_nombre"] ." , ". $row["insp_apep"] ." , ".$row["insp_apem"];
                $sub_array[] = $row["insp_dni"];
                $sub_array[] = '
                        <td class="dropdown hidden-xs-down show">
                            <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info" aria-expanded="true"><i class="icon ion-more"></i></a>
                            <div class="dropdown-menu dropdown-menu-left pd-10">
                                <nav class="nav nav-style-1 flex-column">
                                    <a href="#" class="nav-link" onclick="eliminar(' . $row["cert_id"] . ')">Eliminar</a>
                                    <a href="#" class="nav-link" onclick="generar(' . $row["cert_id"] . ')">Generar</a>
                                </nav>
                            </div><!-- dropdown-menu -->
                        </td>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
        case "mostrar_certificado_detalle":
            $datos=$certificado->get_propietarios_x_id_certificado($_POST["cert_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output[] = [
                        "prop_id" => $row["prop_id"],
                        "prop_nombre" => $row["prop_nombre"],
                        "prop_apep" => $row["prop_apep"],
                        "prop_apem" => $row["prop_apem"],
                        "prop_estadocivil" => $row["prop_estadocivil"],
                        "prop_dni" => $row["prop_dni"],
                        "prop_tipo" => $row["prop_tipo"],
                        "cert_id" => $row["cert_id"],
                        "cert_area" => $row["cert_area"],
                        "cert_perimetro" => $row["cert_perimetro"],
                        "cert_nomtipourb" => $row["cert_nomtipourb"],
                        "cert_nomtipovia"=> $row["cert_nomtipovia"],
                        "cert_uso" => $row["cert_uso"],
                        "cert_frente" => $row["cert_frente"],
                        "cert_derecha" => $row["cert_derecha"],
                        "cert_izquierda" => $row["cert_izquierda"],
                        "cert_fondo" => $row["cert_fondo"],
                        "cert_medfrente" => $row["cert_medfrente"],  
                        "cert_medderecha" => $row["cert_medderecha"],
                        "cert_medizquierda" => $row["cert_medizquierda"],
                        "cert_medfondo" => $row["cert_medfondo"],     
                        "cert_manzana" => $row["cert_manzana"],
                        "cert_lote" => $row["cert_lote"],
                        "cert_etapa" => $row["cert_etapa"],
                        "cert_numregdoc" => $row["cert_numregdoc"],
                        "cert_numexpe" => $row["cert_numexpe"],
                        "cert_tecinf" => $row["cert_tecinf"],
                        "cert_numcert" => $row["cert_numcert"],
                        "cert_estimp" => $row["cert_estimp"],
                        "cert_numactainsp" => $row["cert_numactainsp"],
                        "insp_id" => $row["insp_id"],
                        "insp_nombre" => $row["insp_nombre"],
                        "insp_apep" => $row["insp_apep"],
                        "insp_apem" => $row["insp_apem"],
                        "insp_dni" => $row["insp_dni"]];

                                           
            }
            echo json_encode($output);
        }
            break; 
            case 'imprimir':
                if (isset($_POST['cert_id'])) {
                    $datosPropietarios = $propietario->get_propietario_x_id_certificado($_POST["cert_id"]);
                    $datosCertificado = $certificado->get_datoscertificado_x_id_certificado($_POST["cert_id"]);
                    
                    if (!empty($datosPropietarios) && !empty($datosCertificado)) {
                        function Footer() {
                            // Posición a 1.5 cm del final
                            $this->SetY(-15);
                            // Arial italic 8
                            $this->SetFont('Arial', 'I', 8);
                            // Número de página
                            $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
                        }
                    
                    
                    
                    $pdf = new PDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', '', 12);

                    $pdf->SetMargins(15, 15, 15); // Márgenes izquierdo, superior, derecho
                    $pdf->SetAutoPageBreak(true, 10); // Ha

                    $posXImagenCentrada = ($pdf->GetPageWidth() / 2) - 80; // Centrar la imagen
                    $pdf->SetX($posXImagenCentrada);
                    $pdf->Image('../public/logo144.png', $pdf->GetX() + 10, $pdf->GetY(), 20);
                    $imagenY = $pdf->GetY(); // Guardar la posición Y después de la imagen
                    $imagenX = $pdf->GetX(); 
                    $pdf->Ln(20); // Espacio después de la imagen

                    // Encabezado

                    $pdf->SetFont('Arial', 'B', 6);
                    // Calcular el ancho del bloque de texto
                    $bloqueAncho = 50; // Define el ancho del bloque de texto (ajústalo según tu necesidad)
                    // Calcular la posición X para centrar el bloque de texto
                    $posXImagenCentrada = ($pdf->GetPageWidth() - $bloqueAncho) / 2;
                    $pdf->SetX($posXImagenCentrada);
                    $texto = "MUNICIPALIDAD PROVINCIAL DE CHICLAYO\n";
                    $texto .= "GERENCIA DE DESARROLLO URBANO\n";
                    $texto .= "SUBGERENCIA DE OBRAS PRIVADAS";
                    // Crear una celda invisible para posicionar el bloque de texto centrado
                    $pdf->Cell($bloqueAncho, 0, '', 0, 0, 'C');
                    $pdf->Ln(2); // Espacio después de la celda invisible
                    // Dibujar el texto alineado a la izquierda dentro del bloque centrado
                    $pdf->MultiCell($bloqueAncho, 2, utf8_decode($texto), 0, 'C');
                    $pdf->Ln(5);

                    // Título del certificado
                    $pdf->SetFont('Arial', 'B', 16);
                    $pdf->Cell(0, 6, utf8_decode('CERTIFICADO DE POSESION N° '.$datosCertificado[0]['cert_numcert'].'  /'.$datosCertificado[0]['cert_fechcrea_año'].'-GDU-MPCH' ), 0, 1, 'C');
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(0, 6, utf8_decode('Reg. Doc. N° 658739 - '.$datosCertificado[0]['cert_fechcrea_año'].'.'.'                                              Expediente Nº '.$datosCertificado[0]['cert_numexpe'].'.'), 0, 1, 'C');
                    $pdf->Ln(6);
                    
                    // Datos del beneficiario
                    $pdf->SetFont('Arial', '', 11);
                    $pdf->MultiCell(0, 5, utf8_decode('de Asentamientos Humanos de la Municipalidad Provincial de Chiclayo, otorgan el presente Certificado de Posesión a favor de:'), 0, 'L');
                    $pdf->Ln(4);

                    
                    foreach ($datosPropietarios as $prop) {
                        $pdf->SetFont('Arial', 'B', 14);
                        $pdf->Cell(0, 6, utf8_decode($prop['prop_nombre'].' '.$prop['prop_apep'].' '.$prop['prop_apem']), 0, 1, 'C');
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->Cell(0, 6, utf8_decode('DNI N° '.$prop['prop_dni']), 0, 1, 'C');
                        $pdf->Ln(4);
                    }
                    
                     // Detalles de la posesión                                                                                                                                                                                                                                                                                                             
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->MultiCell(0, 5, utf8_decode('Según inspección realizada se ha constatado que se posesionaria del predio ubicado en la '.$datosCertificado[0]['tivi_descripcion'].' '.$datosCertificado[0]['cert_nomtipovia'].', Mz "'.$datosCertificado[0]['cert_manzana'].'" Lote N° '.$datosCertificado[0]['cert_lote'].' del '.$datosCertificado[0]['tiur_descripcion'].' '.$datosCertificado[0]['cert_nomtipourb'].' del Distrito de Chiclayo, Provincia de Chiclayo y Departamento de Lambayeque y tiene las siguientes características:'), 0, 'L');
                    $pdf->Ln(2); 

                    $pdf->SetFont('Arial', '', 12);
                    $left_margin = 20;
                    $label_width = 50;  // Ancho para las etiquetas
                    $colon_width = 5;   // Ancho para los dos puntos
                    $value_width = 50;  // Ancho para los valores

                    $pdf->SetX($left_margin);
                    $pdf->Cell($label_width, 5, utf8_decode('Perímetro'), 0, 0, 'L');
                    $pdf->Cell($colon_width, 5, utf8_decode(':'), 0, 0, 'L');
                    $pdf->Cell($value_width, 5, utf8_decode($datosCertificado[0]['cert_perimetro']), 0, 1, 'L');

                    $pdf->SetX($left_margin);
                    $pdf->Cell($label_width, 5, utf8_decode('Área'), 0, 0, 'L');
                    $pdf->Cell($colon_width, 5, utf8_decode(':'), 0, 0, 'L');
                    $pdf->Cell($value_width, 5, utf8_decode($datosCertificado[0]['cert_area']), 0, 1, 'L');
                    $pdf->Ln(3);

                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(0, 4, utf8_decode('Linderos y Medidas Peramétricas:'), 0, 1, 'L');
                    $pdf->Ln(3);

                    $pdf->SetFont('Arial', '', 11);
                    $linderos = [
                        ['label' => 'Por el Frente', 'value' => $datosCertificado[0]['cert_frente'] . ', con ' . $datosCertificado[0]['cert_medfrente'] . ' ml'],
                        ['label' => 'Por la Derecha', 'value' => $datosCertificado[0]['cert_derecha'] . ', con ' . $datosCertificado[0]['cert_medderecha'] . ' ml'],
                        ['label' => 'Por la Izquierda', 'value' => $datosCertificado[0]['cert_izquierda'] . ', con ' . $datosCertificado[0]['cert_medizquierda'] . ' ml'],
                        ['label' => 'Por el Fondo', 'value' => $datosCertificado[0]['cert_fondo'] . ', con ' . $datosCertificado[0]['cert_medfondo'] . ' ml']
                    ];
    
                    foreach ($linderos as $lindero) {
                        $pdf->SetX($left_margin);
                        $pdf->Cell($label_width, 4, utf8_decode($lindero['label']), 0, 0, 'L');
                        $pdf->Cell($colon_width, 4, utf8_decode(':'), 0, 0, 'L');
                        $pdf->Cell($value_width, 4, utf8_decode($lindero['value']), 0, 1, 'L');
                    }
                    $pdf->Ln(3);

                    $pdf->SetX($left_margin);
                    $pdf->Cell($label_width, 5, utf8_decode('Uso'), 0, 0, 'L');
                    $pdf->Cell($colon_width, 5, utf8_decode(':'), 0, 0, 'L');
                    $pdf->Cell($value_width, 5, utf8_decode($datosCertificado[0]['cert_uso']), 0, 1, 'L');

                    $pdf->Ln(4);
                    

                    // Base Legal
                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(0, 4, utf8_decode('BASE LEGAL:'), 0, 1, 'L');
                    $pdf->SetFont('Arial', '', 11);
                    $pdf->MultiCell(0, 4, utf8_decode('Artículo 24 de la Ley N° 28687 "Ley de Desarrollo y Complementaria de Formalización de la Propiedad Informal, Acceso al Suelo y Dotación de Servicios Básicos."'), 0, 'L');
                    $pdf->SetFont('Arial', 'BI', 8);
                    $pdf->MultiCell(0, 4, utf8_decode('NOTA: Este Certificado no tiene validez para fines de Prescripción Adquisitiva de Dominio.'), 0, 'L');
                    $pdf->Ln(2);
                    
                    // Informe Técnico
                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(0, 4, utf8_decode('INFORME TECNICO:'), 0, 1, 'L');
                    $pdf->SetFont('Arial', '', 11);
                    $pdf->Cell(0, 4, utf8_decode('Informe Técnico N° ' . $datosCertificado[0]['cert_tecinf']), 0, 1, 'L');
                    $pdf->Cell(0, 4, utf8_decode('Acta de Inspección N° ' . $datosCertificado[0]['cert_numactainsp']), 0, 1, 'L');
                    $pdf->Cell(0, 4, utf8_decode('Inspector: ' . $datosCertificado[0]['insp_nombre'].' '.$datosCertificado[0]['insp_apep'].' '.$datosCertificado[0]['insp_apem']), 0, 1, 'L');
                    $pdf->SetFont('Arial', 'BI', 8);
                    $pdf->MultiCell(0, 4, utf8_decode('Este documento carece de valor para realizar traspasos, acciones judiciales, tampoco constituye reconocimiento alguno que afecte el derecho de propiedad del titular del terreno.'), 0, 'L');
                    $pdf->Ln(6);
                    
                    // Firma y Fecha
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->MultiCell(0, 5, utf8_decode('SE OTORGA EL PRESENTE CERTIFICADO A SOLICITUD DE LA INTERESADA, PARA GESTIONAR LA FACTIBILIDAD DE SERVICIOS BASICOS DESCRITOS EN LA BASE LEGAL MENCIONADA.'), 0, 'L');
                    $pdf->Ln(6);
                    
                    $pdf->Cell(0, 10, utf8_decode('Chiclayo, '.$datosCertificado[0]['cert_fechcrea']), 0, 1, 'R');
                    $pdf->Ln(6);
                    
                    
                    // Firmas
                    $pdf->Ln(10); // Espacio antes de las firmas

                    // Definir la altura y ancho de las áreas de firma
                    $firmWidth = 60;  // Ancho de cada área de firma
                    $firmHeight = 10; // Altura de cada área de firma
                    $spacing = 10;    // Espacio entre las firmas
                    $startY = $pdf->GetY(); // Guardar la posición vertical actual

                    // Calcular la posición inicial para las firmas
                    $pageWidth = $pdf->GetPageWidth();
                    $startX = ($pageWidth - (3 * $firmWidth + 2 * $spacing)) / 2; // Centrar las firmas horizontalmente

                    // Imprimir la primera firma
                    $pdf->SetY($startY);
                    $pdf->SetX($startX);
                    $pdf->Cell($firmWidth, $firmHeight, utf8_decode('....................................'), 0, 0, 'C');
                    $pdf->Ln(); // Nueva línea para el texto debajo de la firma
                    $pdf->SetX($startX);
                    $pdf->Cell($firmWidth, $firmHeight, utf8_decode('Técnico'), 0, 1, 'C');

                    // Imprimir la segunda firma
                    $pdf->SetY($startY);
                    $pdf->SetX($startX + $firmWidth + $spacing); // Ajustar el espacio entre las firmas
                    $pdf->Cell($firmWidth, $firmHeight, utf8_decode('....................................'), 0, 0, 'C');
                    $pdf->Ln(); // Nueva línea para el texto debajo de la firma
                    $pdf->SetX($startX + $firmWidth + $spacing);
                    $pdf->Cell($firmWidth, $firmHeight, utf8_decode('Subgerente'), 0, 1, 'C');

                    // Imprimir la tercera firma
                    $pdf->SetY($startY);
                    $pdf->SetX($startX + 2 * ($firmWidth + $spacing)); // Ajustar el espacio entre las firmas
                    $pdf->Cell($firmWidth, $firmHeight, utf8_decode('....................................'), 0, 0, 'C');
                    $pdf->Ln(); // Nueva línea para el texto debajo de la firma
                    $pdf->SetX($startX + 2 * ($firmWidth + $spacing));
                    $pdf->Cell($firmWidth, $firmHeight, utf8_decode('Gerente'), 0, 1, 'C');

                    
                    // Salida del PDF
                    $pdf->Output('F', 'Certificado_de_Posesion.pdf');
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: inline; filename="Certificado_de_Posesion.pdf"');
                    readfile('Certificado_de_Posesion.pdf');
                }
                    } else {
                        // Manejar el caso cuando no hay datos
                        echo "No se encontraron datos para generar el PDF.";
                    }
                
                break;

            case 'generar_reporte':
                require_once("../public/plantilla_reporte_excel.php"); // Asegúrate de que esta ruta sea correcta y apunte a tu archivo
                
                // Obtener los parámetros desde POST
                $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
                $completo = isset($_POST['completo']) ? $_POST['completo'] : '';
                $urb = isset($_POST['urb']) ? $_POST['urb'] : '';
                
                // Obtener datos desde el método get_titulo
                $datosExcel = $certificado->get_certificado_($fecha, $completo, $urb);
                
                // Crear una instancia de la clase ExcelReport
                $report = new ExcelReport();
            
                // Establecer título para el archivo Excel
                $report->setTitle('Reporte de Certificados');
            
                // Establecer encabezados para el archivo Excel
                $headers = [
                    
                    'TIPO DE URBANIZACION', 'Mz.', 'LOTE', 'ETAPA',
                    'PROPIETARIO (1)', 'DNI (1)', 'ESTADO CIVIL (1)',
                    'PROPIETARIO (2)', 'DNI (2)', 'ESTADO CIVIL (2)',
                    'AREA', 'PERIMETRO', 'POR EL FRENTE',
                    'POR LA DERECHA ENTRANDO', 'POR LA IZQUIERDA ENTRANDO',
                    'POR FONDO',
                    'Num. Reg. Doc.', 'Num. Expediente', 'Inf. Tecnico', 
                    'Num. Acta Insp.', 'Insp. Nombre','Insp. Ap. Paterno',
                    'Insp. Ap. Materno', 'Insp. DNI'
                    
                ];
                $report->setHeaders($headers);
                
                // Agregar filas de datos al archivo Excel
                foreach ($datosExcel as $row) {
                    $report->addRow([
                        
                        $row["tiur_abr"].' '.$row["cert_nomtipourb"],
                        $row["cert_manzana"], 
                        $row["cert_lote"],
                        $row["cert_etapa"],
                        $row["prop_nombre1"].' '.$row["prop_apep1"].' '.$row["prop_apem1"],
                        $row["prop_dni1"], 
                        $row["prop_estadocivil1"], 
                        $row["prop_nombre2"].' '.$row["prop_apep2"].' '.$row["prop_apem2"],
                        $row['prop_dni2'], 
                        $row['prop_estadocivil2'], 
                      
                        $row['cert_area'], 
                        $row['cert_perimetro'], 
                        $row['cert_frente'].' con , '.$row['cert_medfrente'].' mL ', 
                        $row['cert_derecha'].' con , '.$row['cert_medderecha'].'mL ', 
                        $row['cert_izquierda'].' con , '.$row['cert_medizquierda'].' mL ',
                        $row['cert_fondo'].' con , '.$row['cert_medfondo'].' mL ',
        
                        $row['cert_numregdoc'], 
						$row['cert_numexpe'], 
						$row['cert_tecinf'], 
						$row['cert_numactainsp'], 
						$row['insp_nombre'], 
						$row['insp_apep'], 
						$row['insp_apem'], 
						$row['insp_dni']
                        
                    ]);
                }
            
                // Descargar el archivo Excel
                $report->download('reporte_certificados.xlsx');
                break;
            case 'imprimir_x_imp':
            $idcertificadosSINIMP = $certificado->get_certificado_x_estimp();
            
            if (!empty($idcertificadosSINIMP)) {
                $pdf = new PDF();
                $pdf->AddPage();
                $pdf->SetFont('Arial', '', 12);
                $pdf->SetMargins(15, 15, 15); // Márgenes izquierdo, superior, derecho
                $pdf->SetAutoPageBreak(true, 10); // Habilitar salto de página automático
                
                foreach ($idcertificadosSINIMP as $cert) {
                    $cert_id = $cert['cert_id'];
                    $datosPropietarios = $propietario->get_propietario_x_id_certificado($cert_id);
                    $datosCertificado = $certificado->get_datoscertificado_x_id_certificado($cert_id);
                    
                    if (!empty($datosPropietarios) && !empty($datosCertificado)) {
                        $posXImagenCentrada = ($pdf->GetPageWidth() / 2) - 80; // Centrar la imagen
                            $pdf->SetX($posXImagenCentrada);
                            $pdf->Image('../public/logo144.png', $pdf->GetX() + 10, $pdf->GetY(), 20);
                            $imagenY = $pdf->GetY(); // Guardar la posición Y después de la imagen
                            $imagenX = $pdf->GetX(); 
                            $pdf->Ln(20); // Espacio después de la imagen

                            // Encabezado

                            $pdf->SetFont('Arial', 'B', 6);
                            // Calcular el ancho del bloque de texto
                            $bloqueAncho = 50; // Define el ancho del bloque de texto (ajústalo según tu necesidad)
                            // Calcular la posición X para centrar el bloque de texto
                            $posXImagenCentrada = ($pdf->GetPageWidth() - $bloqueAncho) / 2;
                            $pdf->SetX($posXImagenCentrada);
                            $texto = "MUNICIPALIDAD PROVINCIAL DE CHICLAYO\n";
                            $texto .= "GERENCIA DE DESARROLLO URBANO\n";
                            $texto .= "SUBGERENCIA DE OBRAS PRIVADAS";
                            // Crear una celda invisible para posicionar el bloque de texto centrado
                            $pdf->Cell($bloqueAncho, 0, '', 0, 0, 'C');
                            $pdf->Ln(2); // Espacio después de la celda invisible
                            // Dibujar el texto alineado a la izquierda dentro del bloque centrado
                            $pdf->MultiCell($bloqueAncho, 2, utf8_decode($texto), 0, 'C');
                            $pdf->Ln(5);

                            // Título del certificado
                            $pdf->SetFont('Arial', 'B', 16);
                            $pdf->Cell(0, 6, utf8_decode('CERTIFICADO DE POSESION N° '.$datosCertificado[0]['cert_numcert'].'  /'.$datosCertificado[0]['cert_fechcrea_año'].'-GDU-MPCH' ), 0, 1, 'C');
                            $pdf->SetFont('Arial', 'B', 12);
                            $pdf->Cell(0, 6, utf8_decode('Reg. Doc. N° 658739 - 2024.'.'                                         Expediente Nº '.$datosCertificado[0]['cert_numexpe'].'.'), 0, 1, 'C');
                            $pdf->Ln(6);
                            
                            // Datos del beneficiario
                            $pdf->SetFont('Arial', '', 11);
                            $pdf->MultiCell(0, 5, utf8_decode('de Asentamientos Humanos de la Municipalidad Provincial de Chiclayo, otorgan el presente Certificado de Posesión a favor de:'), 0, 'L');
                            $pdf->Ln(4);

                            
                            foreach ($datosPropietarios as $prop) {
                                $pdf->SetFont('Arial', 'B', 14);
                                $pdf->Cell(0, 6, utf8_decode($prop['prop_nombre'].' '.$prop['prop_apep'].' '.$prop['prop_apem']), 0, 1, 'C');
                                $pdf->SetFont('Arial', 'B', 12);
                                $pdf->Cell(0, 6, utf8_decode('DNI N° '.$prop['prop_dni']), 0, 1, 'C');
                                $pdf->Ln(4);
                            }
                            
                            // Detalles de la posesión                                                                                                                                                                                                                                                                                                             
                            $pdf->SetFont('Arial', 'B', 12);
                            $pdf->MultiCell(0, 5, utf8_decode('Según inspección realizada se ha constatado que se posesionaria del predio ubicado en la '.$datosCertificado[0]['tivi_descripcion'].' '.$datosCertificado[0]['cert_nomtipovia'].', Mz "'.$datosCertificado[0]['cert_manzana'].'" Lote N° '.$datosCertificado[0]['cert_lote'].' del '.$datosCertificado[0]['tiur_descripcion'].' '.$datosCertificado[0]['cert_nomtipourb'].' del Distrito de Chiclayo, Provincia de Chiclayo y Departamento de Lambayeque y tiene las siguientes características:'), 0, 'L');
                            $pdf->Ln(2); 

                            $pdf->SetFont('Arial', '', 12);
                            $left_margin = 20;
                            $label_width = 50;  // Ancho para las etiquetas
                            $colon_width = 5;   // Ancho para los dos puntos
                            $value_width = 50;  // Ancho para los valores

                            $pdf->SetX($left_margin);
                            $pdf->Cell($label_width, 5, utf8_decode('Perímetro'), 0, 0, 'L');
                            $pdf->Cell($colon_width, 5, utf8_decode(':'), 0, 0, 'L');
                            $pdf->Cell($value_width, 5, utf8_decode($datosCertificado[0]['cert_perimetro']), 0, 1, 'L');

                            $pdf->SetX($left_margin);
                            $pdf->Cell($label_width, 5, utf8_decode('Área'), 0, 0, 'L');
                            $pdf->Cell($colon_width, 5, utf8_decode(':'), 0, 0, 'L');
                            $pdf->Cell($value_width, 5, utf8_decode($datosCertificado[0]['cert_area']), 0, 1, 'L');
                            $pdf->Ln(3);

                            $pdf->SetFont('Arial', 'B', 11);
                            $pdf->Cell(0, 4, utf8_decode('Linderos y Medidas Peramétricas:'), 0, 1, 'L');
                            $pdf->Ln(3);

                            $pdf->SetFont('Arial', '', 11);
                            $linderos = [
                                ['label' => 'Por el Frente', 'value' => $datosCertificado[0]['cert_frente'] . ', con ' . $datosCertificado[0]['cert_medfrente'] . ' ml'],
                                ['label' => 'Por la Derecha', 'value' => $datosCertificado[0]['cert_derecha'] . ', con ' . $datosCertificado[0]['cert_medderecha'] . ' ml'],
                                ['label' => 'Por la Izquierda', 'value' => $datosCertificado[0]['cert_izquierda'] . ', con ' . $datosCertificado[0]['cert_medizquierda'] . ' ml'],
                                ['label' => 'Por el Fondo', 'value' => $datosCertificado[0]['cert_fondo'] . ', con ' . $datosCertificado[0]['cert_medfondo'] . ' ml']
                            ];
            
                            foreach ($linderos as $lindero) {
                                $pdf->SetX($left_margin);
                                $pdf->Cell($label_width, 4, utf8_decode($lindero['label']), 0, 0, 'L');
                                $pdf->Cell($colon_width, 4, utf8_decode(':'), 0, 0, 'L');
                                $pdf->Cell($value_width, 4, utf8_decode($lindero['value']), 0, 1, 'L');
                            }
                            $pdf->Ln(3);

                            $pdf->SetX($left_margin);
                            $pdf->Cell($label_width, 5, utf8_decode('Uso'), 0, 0, 'L');
                            $pdf->Cell($colon_width, 5, utf8_decode(':'), 0, 0, 'L');
                            $pdf->Cell($value_width, 5, utf8_decode($datosCertificado[0]['cert_uso']), 0, 1, 'L');

                            $pdf->Ln(4);
                            

                            // Base Legal
                            $pdf->SetFont('Arial', 'B', 11);
                            $pdf->Cell(0, 4, utf8_decode('BASE LEGAL:'), 0, 1, 'L');
                            $pdf->SetFont('Arial', '', 11);
                            $pdf->MultiCell(0, 4, utf8_decode('Artículo 24 de la Ley N° 28687 "Ley de Desarrollo y Complementaria de Formalización de la Propiedad Informal, Acceso al Suelo y Dotación de Servicios Básicos."'), 0, 'L');
                            $pdf->SetFont('Arial', 'BI', 8);
                            $pdf->MultiCell(0, 4, utf8_decode('NOTA: Este Certificado no tiene validez para fines de Prescripción Adquisitiva de Dominio.'), 0, 'L');
                            $pdf->Ln(2);
                            
                            // Informe Técnico
                            $pdf->SetFont('Arial', 'B', 11);
                            $pdf->Cell(0, 4, utf8_decode('INFORME TECNICO:'), 0, 1, 'L');
                            $pdf->SetFont('Arial', '', 11);
                            $pdf->Cell(0, 4, utf8_decode('Informe Técnico N° ' . $datosCertificado[0]['cert_tecinf']), 0, 1, 'L');
                            $pdf->Cell(0, 4, utf8_decode('Acta de Inspección N° ' . $datosCertificado[0]['cert_numactainsp']), 0, 1, 'L');
                            $pdf->Cell(0, 4, utf8_decode('Inspector: ' . $datosCertificado[0]['insp_nombre'].' '.$datosCertificado[0]['insp_apep'].' '.$datosCertificado[0]['insp_apem']), 0, 1, 'L');
                            $pdf->SetFont('Arial', 'BI', 8);
                            $pdf->MultiCell(0, 4, utf8_decode('Este documento carece de valor para realizar traspasos, acciones judiciales, tampoco constituye reconocimiento alguno que afecte el derecho de propiedad del titular del terreno.'), 0, 'L');
                            $pdf->Ln(6);
                            
                            // Firma y Fecha
                            $pdf->SetFont('Arial', 'B', 12);
                            $pdf->MultiCell(0, 5, utf8_decode('SE OTORGA EL PRESENTE CERTIFICADO A SOLICITUD DE LA INTERESADA, PARA GESTIONAR LA FACTIBILIDAD DE SERVICIOS BASICOS DESCRITOS EN LA BASE LEGAL MENCIONADA.'), 0, 'L');
                            $pdf->Ln(6);
                            
                            $pdf->Cell(0, 10, utf8_decode('Chiclayo, '.$datosCertificado[0]['cert_fechcrea']), 0, 1, 'R');
                            $pdf->Ln(6);
                            
                                    // Firmas
                            $pdf->Ln(10); // Espacio antes de las firmas

                            // Definir la altura y ancho de las áreas de firma
                            $firmWidth = 60;  // Ancho de cada área de firma
                            $firmHeight = 10; // Altura de cada área de firma
                            $spacing = 10;    // Espacio entre las firmas
                            $startY = $pdf->GetY(); // Guardar la posición vertical actual

                            // Calcular la posición inicial para las firmas
                            $pageWidth = $pdf->GetPageWidth();
                            $startX = ($pageWidth - (3 * $firmWidth + 2 * $spacing)) / 2; // Centrar las firmas horizontalmente

                            // Imprimir la primera firma
                            $pdf->SetY($startY);
                            $pdf->SetX($startX);
                            $pdf->Cell($firmWidth, $firmHeight, utf8_decode('....................................'), 0, 0, 'C');
                            $pdf->Ln(); // Nueva línea para el texto debajo de la firma
                            $pdf->SetX($startX);
                            $pdf->Cell($firmWidth, $firmHeight, utf8_decode('Técnico'), 0, 1, 'C');

                            // Imprimir la segunda firma
                            $pdf->SetY($startY);
                            $pdf->SetX($startX + $firmWidth + $spacing); // Ajustar el espacio entre las firmas
                            $pdf->Cell($firmWidth, $firmHeight, utf8_decode('....................................'), 0, 0, 'C');
                            $pdf->Ln(); // Nueva línea para el texto debajo de la firma
                            $pdf->SetX($startX + $firmWidth + $spacing);
                            $pdf->Cell($firmWidth, $firmHeight, utf8_decode('Subgerente'), 0, 1, 'C');

                            // Imprimir la tercera firma
                            $pdf->SetY($startY);
                            $pdf->SetX($startX + 2 * ($firmWidth + $spacing)); // Ajustar el espacio entre las firmas
                            $pdf->Cell($firmWidth, $firmHeight, utf8_decode('....................................'), 0, 0, 'C');
                            $pdf->Ln(); // Nueva línea para el texto debajo de la firma
                            $pdf->SetX($startX + 2 * ($firmWidth + $spacing));
                            $pdf->Cell($firmWidth, $firmHeight, utf8_decode('Gerente'), 0, 1, 'C');
                            

                            $certificado->cambiarestado_impreso($cert_id, 'impreso');
                        
                    }

                    // Salto de página si no es el último certificado
                    if ($cert !== end($idcertificadosSINIMP)) {
                        $pdf->AddPage();
                    }
                }

                // Salida del PDF al navegador
                $pdf->Output('I', 'CertificadoDePosesion.pdf');
            } else {
                echo 'No hay certificados pendientes de impresión.';
            }
            break;
            case 'imprimir_x_firm1':
                $idcertificadosFIRM1 = $certificado->get_certificado_x_firm1();
                
                // Inicializa FPDI
                $pdf = new PDF();
                $pdf->SetAutoPageBreak(true, 10); // Habilitar salto de página automático
            
                if (!empty($idcertificadosFIRM1)) {
                    foreach ($idcertificadosFIRM1 as $cert) {
                        $cert_id = $cert['cert_id'];
                        $datosPDF = $certificado->get_pdf_x_id_certificado($cert_id);
            
                        if (!empty($datosPDF)) {
                            // Decodifica el contenido Base64
                            $pdfData = base64_decode($datosPDF['cert_firmapdf']);
            
                            // Crea un archivo temporal para almacenar el PDF
                            $tempFilePath = tempnam(sys_get_temp_dir(), 'cert') . '.pdf';
                            file_put_contents($tempFilePath, $pdfData);
            
                            // Añade todas las páginas del PDF decodificado al documento final
                            $pageCount = $pdf->setSourceFile($tempFilePath);
                            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                                $tplIdx = $pdf->importPage($pageNo);
                                $pdf->AddPage();
                                $pdf->useTemplate($tplIdx);
                            }
            
                            // Cambia el estado del certificado a "impreso"
                            $certificado->cambiarestado_impreso($cert_id, 'impreso');
                        }
                    }
            
                    // Envía los encabezados para mostrar el PDF en el navegador
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: inline; filename="Certificados.pdf"');
            
                    // Salida de todo el PDF combinado
                    $pdf->Output();
            
                } else {
                    echo 'No hay certificados pendientes de impresión.';
                }
                break;
            case 'imprimir_x_firm2':
                $idcertificadosFIRM2 = $certificado->get_certificado_x_firm2();
                
                // Inicializa FPDI
                $pdf = new PDF();
                $pdf->SetAutoPageBreak(true, 10); // Habilitar salto de página automático
            
                if (!empty($idcertificadosFIRM2)) {
                    foreach ($idcertificadosFIRM2 as $cert) {
                        $cert_id = $cert['cert_id'];
                        $datosPDF = $certificado->get_pdf_x_id_certificado($cert_id);
            
                        if (!empty($datosPDF)) {
                            // Decodifica el contenido Base64
                            $pdfData = base64_decode($datosPDF['cert_firmapdf']);
            
                            // Crea un archivo temporal para almacenar el PDF
                            $tempFilePath = tempnam(sys_get_temp_dir(), 'cert') . '.pdf';
                            file_put_contents($tempFilePath, $pdfData);
            
                            // Añade todas las páginas del PDF decodificado al documento final
                            $pageCount = $pdf->setSourceFile($tempFilePath);
                            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                                $tplIdx = $pdf->importPage($pageNo);
                                $pdf->AddPage();
                                $pdf->useTemplate($tplIdx);
                            }
            
                            // Cambia el estado del certificado a "impreso"
                            $certificado->cambiarestado_impreso($cert_id, 'impreso');
                        }
                    }
            
                    // Envía los encabezados para mostrar el PDF en el navegador
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: inline; filename="Certificados_firm2.pdf"');
            
                    // Salida de todo el PDF combinado
                    $pdf->Output();
            
                } else {
                    echo 'No hay certificados pendientes de impresión.';
                }
                break;
            case 'imprimir_x_firm3':
                $idcertificadosFIRM3 = $certificado->get_certificado_x_firm3();
                
                // Inicializa FPDI
                $pdf = new PDF();
                $pdf->SetAutoPageBreak(true, 10); // Habilitar salto de página automático
            
                if (!empty($idcertificadosFIRM3)) {
                    foreach ($idcertificadosFIRM3 as $cert) {
                        $cert_id = $cert['cert_id'];
                        $datosPDF = $certificado->get_pdf_x_id_certificado($cert_id);
            
                        if (!empty($datosPDF)) {
                            // Decodifica el contenido Base64
                            $pdfData = base64_decode($datosPDF['cert_firmapdf']);
            
                            // Crea un archivo temporal para almacenar el PDF
                            $tempFilePath = tempnam(sys_get_temp_dir(), 'cert') . '.pdf';
                            file_put_contents($tempFilePath, $pdfData);
            
                            // Añade todas las páginas del PDF decodificado al documento final
                            $pageCount = $pdf->setSourceFile($tempFilePath);
                            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                                $tplIdx = $pdf->importPage($pageNo);
                                $pdf->AddPage();
                                $pdf->useTemplate($tplIdx);
                            }
            
                            // Cambia el estado del certificado a "impreso"
                            $certificado->cambiarestado_impreso($cert_id, 'impreso');
                        }
                    }
            
                    // Envía los encabezados para mostrar el PDF en el navegador
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: inline; filename="Certificados_completos.pdf"');
            
                    // Salida de todo el PDF combinado
                    $pdf->Output();
            
                } else {
                    echo 'No hay certificados pendientes de impresión.';
                }
                break;


    case 'abrir':
        $datos = $certificado->get_distrito($_POST['cod_prov_sunat']);
        if (is_array($datos) == true and count($datos) > 0) {
            $html = " <option label='Seleccione'></option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['cod_ubigeo_sunat'] . "'>" . $row['desc_ubigeo_sunat'] . "</option>";
            }
            echo $html;
        }

        break;
        case 'case':
            // Obtener los parámetros de la solicitud
            $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
            $completo = isset($_POST['completo']) ? $_POST['completo'] : '';
            $urb = isset($_POST['urb']) ? $_POST['urb'] : '';
        
            // Obtener los datos
            $datos = $certificado->get_certificado_($fecha, $completo, $urb);
        
            // Formatear los datos
            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();
               
                $sub_array[] = $row["tiur_abr"].' '.$row["cert_nomtipourb"];
                $sub_array[] = $row["cert_manzana"];
                $sub_array[] = $row["cert_lote"];
                $sub_array[] = $row["cert_etapa"];
                $sub_array[] = $row["prop_nombre1"].' '.$row["prop_apep1"].' '.$row["prop_apem1"];
                $sub_array[] = $row["prop_dni1"];
                $sub_array[] = $row["prop_estadocivil1"];
                $sub_array[] = $row["prop_nombre2"].' '.$row["prop_apep2"].' '.$row["prop_apem2"];
                $sub_array[] = $row["prop_dni2"];
                $sub_array[] = $row["prop_estadocivil2"];
                $sub_array[] = $row["cert_area"];
                $sub_array[] = $row["cert_perimetro"];
                $sub_array[] = $row['cert_frente'].' con , '.$row['cert_medfrente'].' mL ';
                $sub_array[] = $row['cert_derecha'].' con , '.$row['cert_medderecha'].'mL ';
                $sub_array[] = $row['cert_izquierda'].' con , '.$row['cert_medizquierda'].' mL ';
                $sub_array[] = $row['cert_fondo'].' con , '.$row['cert_medfondo'].' mL ';
                $sub_array[] = $row["cert_numregdoc"];
                $sub_array[] = $row["cert_numexpe"];
                $sub_array[] = $row["cert_tecinf"];
                $sub_array[] = $row["cert_numactainsp"];
                $sub_array[] = $row["insp_nombre"];
                $sub_array[] = $row["insp_apep"];
                $sub_array[] = $row["insp_apem"];
                $sub_array[] = $row["insp_dni"];
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
            
        case "combo_fecha":
            $datos = $certificado->combo_fechcrea();
            if (is_array($datos) && count($datos) > 0) {
                $html = "<option label='Seleccione'></option>";
                foreach ($datos as $row) {
                    $html .= "<option value='{$row}'>{$row}</option>";
                }
                echo $html;
            }
            break;
        case "combo_completo":
            $datos = $certificado->combo_completo();
            if (is_array($datos) && count($datos) > 0) {
                $html = "<option label='Seleccione'></option>";
                foreach ($datos as $row) {
                    $value = ($row == 1) ? 'Completo' : 'Pendiente';
                    $html .= "<option value='{$row}'>{$value}</option>";
                }
                echo $html;
            }
            break;
        case "combo_urb":
            $datos = $certificado->combo_urb();
            if (is_array($datos) && count($datos) > 0) {
                $html = "<option label='Seleccione'></option>";
                foreach ($datos as $row) {
                    $html .= "<option value='{$row}'>{$row}</option>";
                }
                echo $html;
            }
            break;
        case "total_registrados":
            $datos=$certificado->get_total_certificados_registrados();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["registrados"] = $row["registrados"];
                }
                echo json_encode($output);
            }
            break;
        case "total_pendientes":
            $datos=$certificado->get_total_certificados_pendientes();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["pendientes"] = $row["pendientes"];
                }
                echo json_encode($output);
            }
            break;
        case "total_completados":
            $datos=$certificado->get_total_certificados_completados();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["completados"] = $row["completados"];
                }
                echo json_encode($output);
            }
            break;
            case "total_pendientes_subgerente":
                $datos=$certificado->get_total_certificados_pendientes_subgerente();
                if(is_array($datos)==true and count($datos)>0){
                    foreach($datos as $row)
                    {
                        $output["pendientes"] = $row["pendientes"];
                    }
                    echo json_encode($output);
                }
                break;
            case "total_pendientes_gerente":
                $datos=$certificado->get_total_certificados_pendientes_gerente();
                if(is_array($datos)==true and count($datos)>0){
                    foreach($datos as $row)
                    {
                        $output["pendientes"] = $row["pendientes"];
                    }
                    echo json_encode($output);
                }
                break;
            
            case "total_descargables_subgerente":
                $datos=$certificado->get_total_certificados_descargables_subgerente();
                if(is_array($datos)==true and count($datos)>0){
                    foreach($datos as $row)
                    {
                        $output["descargables"] = $row["descargables"];
                    }
                    echo json_encode($output);
                }
                break;
            case "total_descargables_gerente":
                $datos=$certificado->get_total_certificados_descargables_gerente();
                if(is_array($datos)==true and count($datos)>0){
                    foreach($datos as $row)
                    {
                        $output["descargables"] = $row["descargables"];
                    }
                    echo json_encode($output);
                }
                break;
            
        case "mostrar_resumen_certificado":
            $datos=$certificado->get_resumen_certificado();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["nombrepoblacion"];
                $sub_array[] = $row["registrados"];
                $sub_array[] = $row["pendientes"];
                $sub_array[] = $row["descargados"];
                $sub_array[] = '<button type="button" onClick="editar" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>';  
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
        
        
            case "obtener_certificado_abrir":
                $datos = $certificado->get_certificado_id_abrir($_POST["cert_id"]);
                if ($datos && isset($datos['cert_firmapdf'])) {
                    echo $datos['cert_firmapdf'];
                } else {
                    header('HTTP/1.1 404 Not Found');
                    echo 'Archivo no encontrado';
                }
                break;
        case "vistaprevia_pdf":
            $datos = $certificado->get_pdf_x_id_certificado_vista($_POST["cert_id"]);
            if ($datos && isset($datos['cert_firmapdf'])) {
                echo $datos['cert_firmapdf'];
            } else {
                header('HTTP/1.1 404 Not Found');
                echo 'Archivo no encontrado';
            }
            break;
        case "reiniciar_numcert":
            $certificado->reiniciar_numcert();
            break;
        case "cambiar_estimp":
            $certificado->cambiarestado_impreso($_POST["cert_id"]);
            break;
        
        case "cambiar_estnoimp":
            $certificado->cambiarestado_noimpreso($_POST["cert_id"]);
            break;
        case "cambiar_estentrega":
            $certificado->cambiarestado_entrega($_POST["cert_id"]);
            break;
        case "cambiar_esttitulado":
            $certificado->cambiarestado_titulado($_POST["cert_id"]);
            break;
        case "cambiar_estnotitulado":
            $certificado->cambiarestado_notitulado($_POST["cert_id"]);
            break;
        case "cambiar_estadjuntado":
            $certificado->cambiarestado_adjuntado($_POST["cert_id"]);
            break;
        case "cambiar_estnoadjuntado":
            $certificado->cambiarestado_noadjuntado($_POST["cert_id"]);
            break;
        case "cambiar_estfirmado":
            $certificado->cambiarestado_firmado($_POST["cert_id"]);
            break;
        case "cambiar_estfirmado2":
            $certificado->cambiarestado_firmado2($_POST["cert_id"]);
            break;
        case "cambiar_estfirmado3":
            $certificado->cambiarestado_firmado3($_POST["cert_id"]);
            break;
        case "cambiar_estcompleto":
            $certificado->cambiarestado_completo($_POST["cert_id"]);
            break;
        case "update_pdf":
            $certificado->update_pdf($_POST["certx_idx"],$_FILES["cert_firmapdf"]);
            break;
        case "eliminar":
            $certificado->delete_certificado($_POST["cert_id"]);
            break;
    }