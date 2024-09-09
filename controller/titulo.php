<?php
    require_once("../public/plantilla_reporte.php");
    /*TODO: Llamando a cadena de Conexion */
    require_once("../config/conexion.php");
    /*TODO: Llamando a la clase */
    
    require_once("../models/Titulo.php");
    require_once("../models/Propietario.php");
    require_once("../models/Alcalde.php");
    /*TODO: Inicializando Clase */
    $titulo = new Titulo();
    $propietario = new Propietario();
    $alcalde = new Alcalde();
    $output = [];
    /*TODO: Opcion de solicitud de controller */
    switch($_GET["op"]){
/*TODO: Guardar y editar cuando se tenga el ID */
        case "guardaryeditar":
            
            if(empty($_POST["titu_id"])){
                var_dump($_POST);
                $titulo->insert_titulo($_POST["cert_id"],$_POST["alca_id"],$_POST["titu_partelec"],$_POST["titu_partlote"],$_POST["titu_asiento"],$_POST["titu_serie"],$_POST["titu_tipo"],$_POST["titu_tazacion"],$_POST["titu_emp"],$_POST["titu_sector"],$_POST["titu_numresolucion"],$_POST["titu_fecharesolucion"],$_POST["titu_fechaemision"]);
            }else{
                $titulo->update_titulo($_POST["titu_id"],$_POST["cert_id"],$_POST["alca_id"],$_POST["titu_partelec"],$_POST["titu_partlote"],$_POST["titu_asiento"],$_POST["titu_serie"],$_POST["titu_tipo"],$_POST["titu_tazacion"],$_POST["titu_emp"],$_POST["titu_sector"],$_POST["titu_numresolucion"],$_POST["titu_fecharesolucion"],$_POST["titu_fechaemision"]);
            }
            break;
        case "guardar_recibo":
            var_dump($_POST);
            if(!empty($_POST["titu_id_completar"])){
                
                $titulo->update_recibo($_POST["titu_id_completar"],$_POST["titu_numrecibo"]);
            }
            break;
        case "mostrar":
                    $datos = $titulo->get_titulo_id($_POST["titu_id"]);
                    if(is_array($datos)==true and count($datos)<>0){
                        foreach($datos as $row){
                            $output["titu_id"] = $row["titu_id"];
                            $output["cert_id"] = $row["cert_id"];
                            $output["alca_id"] = $row["alca_id"];
                            $output["titu_partelec"] = $row["titu_partelec"];
                            $output["titu_numtitulo"] = $row["titu_numtitulo"];
                            $output["titu_partlote"] = $row["titu_partlote"];
                            $output["titu_asiento"] = $row["titu_asiento"];
                            $output["titu_serie"] = $row["titu_serie"];
                            $output["titu_tipo"] = $row["titu_tipo"];
                            $output["titu_tazacion"] = $row["titu_tazacion"];
                            $output["titu_numresolucion"] = $row["titu_numresolucion"];
                            $output["titu_fecharesolucion"] = $row["titu_fecharesolucion"];
                            $output["titu_fechaemision"] = $row["titu_fechaemision"];
                        }
                        echo json_encode($output);
                    }
                    break;
                    case 'listar_resumen_titulo':
                        // Obtener los parámetros de la solicitud
                        $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
                        $completo = isset($_POST['completo']) ? $_POST['completo'] : '';
                        $urb = isset($_POST['urb']) ? $_POST['urb'] : '';
                    
                        // Obtener los datos
                        $datos = $titulo->get_titulo_resumen($fecha, $completo, $urb);
                    
                        // Formatear los datos
                        $data = array();
                        foreach ($datos as $row) {
                            $sub_array = array();
                            $sub_array[] = $row["titu_partelec"];
                            $sub_array[] = $row["titu_serie"];
                            $sub_array[] = $row["titu_numtitulo"];
                            $sub_array[] = $row["tiur_abr"].' '.$row["cert_nomtipourb"];
                            $sub_array[] = $row["cert_manzana"];
                            $sub_array[] = $row["cert_lote"];
                            $sub_array[] = $row["titu_emp"];
                            $sub_array[] = $row["titu_asiento"];
                            $sub_array[] = $row["prop_nombre1"].' '.$row["prop_apep1"].' '.$row["prop_apem1"];
                            $sub_array[] = $row["prop_dni1"];
                            $sub_array[] = $row["prop_estadocivil1"];
                            $sub_array[] = $row["prop_nombre2"].' '.$row["prop_apep2"].' '.$row["prop_apem2"];
                            $sub_array[] = $row["prop_dni2"];
                            $sub_array[] = $row["prop_estadocivil2"];
                            $sub_array[] = $row["titu_partlote"];
                            $sub_array[] = $row["cert_area"];
                            $sub_array[] = $row['cert_frente'].' con , '.$row['cert_medfrente'].' mL ';
                            $sub_array[] = $row['cert_derecha'].' con , '.$row['cert_medderecha'].'mL ';
                            $sub_array[] = $row['cert_izquierda'].' con , '.$row['cert_medizquierda'].' mL ';
                            $sub_array[] = $row['cert_fondo'].' con , '.$row['cert_medfondo'].' mL ';
                            $sub_array[] = $row["titu_tipo"];
                            $sub_array[] = $row['titu_numresolucion'].'-2022-MPCH-GDU';
                            $sub_array[] = $row["titu_fecharesolucion"];
                            $sub_array[] = $row["titu_fechaemision"];
                            
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
            $datos = $titulo->combo_fechcrea();
            if (is_array($datos) && count($datos) > 0) {
                $html = "<option label='Seleccione'></option>";
                foreach ($datos as $row) {
                    $html .= "<option value='{$row}'>{$row}</option>";
                }
                echo $html;
            }
            break;
        case "combo_completo":
            $datos = $titulo->combo_completo();
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
            $datos = $titulo->combo_urb();
            if (is_array($datos) && count($datos) > 0) {
                $html = "<option label='Seleccione'></option>";
                foreach ($datos as $row) {
                    $html .= "<option value='{$row}'>{$row}</option>";
                }
                echo $html;
            }
            break;
        

        case "mostrar_titulo_propietario":
            $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
            $completo = isset($_POST['completo']) ? $_POST['completo'] : '';
             
            $datos=$titulo->get_titulo_detalle($fecha, $completo);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $highlight_class = ($row["titu_estfirma"] == 4) ? 'highlight-row' : '';
                          
                $impreso = ($row["titu_estimp"] == 0) ? '' : '<span class="status-box status-imp">I</span>';
                $recibo = ($row["titu_estrecibo"] == 0) ? '' : '<span class="status-box status-recibo">R</span>';
                $completo = ($row["titu_est"] == 0) ? '' : '<span class="status-box status-completo">C</span>';

               $adjunto_symbol = ($row["titu_estadj"] == 0) ? '' : '<a href="#" class="fa fa-file-upload file-upload-icon" onclick="vistaprevia(' . $row["titu_id"] . ')"></a>';
                
                $validar_editar = ($row["titu_estfirma"] == 0) ? '<a href="#" class="btn btn-slateblue" onclick="editar(' . $row["titu_id"] . ')">Editar</a>' : '';
                $validar_eliminar = ($row["titu_estfirma"] == 0) ? '<a href="#" class="btn btn-red" onclick="eliminar(' . $row["titu_id"] . ')">Eliminar</a>' : ''; 

                $validar_editar_recibo = ($row["titu_estrecibo"] == 0) ? $validar_editar : '';
                $validar_eliminar_Recibo = ($row["titu_estrecibo"] == 0) ? $validar_eliminar : ''; 

                $validar_titulacion_firmado = ($row["titu_estfirma"] == 3) ? '<a href="#" class="btn btn-yellowgreen" onclick="titulo(' . $row["titu_id"] . ')">Titulacion</a>' : '';
                $validar_titulacion_entregado = ($row["titu_estent"] == 1) ? $validar_titulacion_firmado : '';
                

                $validar_recibo = ($row["titu_estrecibo"] == 0) ? '<a href="#" class="btn btn-yellowgreen" onclick="recibo(' . $row["titu_id"] . ')">Adjuntar Recibo</a>' : '';

                $validar_entrega_firma = ($row["titu_estfirma"] == 4) ? '<button class="btn btn-success" style="background-color: blue; border-color: blue;" onclick="entregar(' . $row["titu_id"] . ')">Entregar</button>' : '';
                $validar_entrega_estimp = ($row["titu_estimp"] == 1) ?  $validar_entrega_firma : '';
                $validar_entrega = ($row["titu_estent"] == 0) ? $validar_entrega_estimp : '<button class="btn btn-success" disabled style="background-color: gray; border-color: gray;">Entregado</button>';

                $validar_firmar_incompleto = ($row["titu_estfirma"] == 0) ? '<button class="btn btn-success" style="background-color: blue; border-color: blue;" onclick="firmar(' . $row["titu_id"] . ')">Derivar</button>' :  '';
                $validar_firmar_adj = ($row["titu_estadj"] == 0) ? '' : $validar_firmar_incompleto;

                $validar_adjuntar_estimp = ($row["titu_estimp"] == 1) ? '<a href="#" class="btn btn-darkblue" onclick="adjuntar(' . $row["titu_id"] . ')">Adjuntar</a>' : '';
                $validar_adjuntar_completo = ($row["titu_est"] == 0) ? $validar_adjuntar_estimp : '';
               

                $validar_generar_recibo = ($row["titu_estrecibo"] == 1) ? '<a href="#" class="btn btn-brown" class="nav-link" onclick="generar(' . $row["titu_id"] . ')">Generar</a>' : '';
                $validar_generar_completo = ($row["titu_est"] == 0) ? $validar_generar_recibo : '<a href="#" class="btn btn-brown" class="nav-link" onclick="abrir(' . $row["titu_id"] . ')">Generar</a>';
                
                    $sub_array[] = $impreso. $recibo . $completo;
                    $sub_array[] = $row["datospropietarios"];
                    $sub_array[] = $row["titu_partelec"];
                    $sub_array[] = $row["titu_numtitulo"];
                    $sub_array[] = $row["titu_partlote"];
                    $sub_array[] = $row["titu_asiento"];
                    $sub_array[] = $row["titu_serie"];
                    $sub_array[] = $row["titu_tipo"];
                    $sub_array[] = $row["titu_tazacion"];
                    $sub_array[] = $row["titu_numresolucion"];
                    $sub_array[] = $row["titu_fecharesolucion"];
                    $sub_array[] = $row["titu_fechaemision"];
                    $sub_array[] = $validar_recibo . $validar_entrega . $validar_firmar_adj;
                    $sub_array[] = '
                        <td class="dropdown hidden-xs-down show">
                            <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info" aria-expanded="true" ><i class="icon ion-more"></i></a>
                            <div class="dropdown-menu dropdown-menu-left pd-10">
                                <nav class="nav nav-style-1 flex-column">
                                     ' . $validar_editar_recibo . '
                                    ' . $validar_eliminar_Recibo . '
                                    ' . $validar_generar_completo . '
                                    ' . $validar_titulacion_entregado . '
                                    ' . $validar_adjuntar_completo . '
                                </nav>
                            </div><!-- dropdown-menu -->
                        </td>';
                    $sub_array[] = $adjunto_symbol;
                    $sub_array['DT_RowClass'] = $highlight_class; // Add this line
                        $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
        case "listar_titulos_pendiente_subgerente":
            $datos=$titulo->get_titulo_detalle_subgerente_pendiente();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $impreso = ($row["titu_estimp"] == 0) ? '' : '<span class="status-box status-imp">I</span>';
                $adjunto_symbol = ($row["titu_estadj"] == 0) ? '' : '<a href="#" class="fa fa-file-upload file-upload-icon" onclick="vistaprevia(' . $row["titu_id"] . ')"></a>';

                $validar_adjuntar_estimp = ($row["titu_estimp"] == 1) ? '<a href="#" class="btn btn-darkblue" class="nav-link" onclick="adjuntar(' . $row["titu_id"] . ')">Adjuntar</a>' :  '';
                $validar_firmar = ($row["titu_estfirma"] == 1) ? '<button class="btn btn-success" style="background-color: blue; border-color: blue;" onclick="firmar(' . $row["titu_id"] . ')">Firmar</button>': '';
                $validar_firmar_adj = ($row["titu_estadj"] == 0) ? '': $validar_firmar;
        
                $sub_array[] = $impreso;
                $sub_array[] = $row["datospropietarios"];
                $sub_array[] = $row["titu_partelec"];
                $sub_array[] = $row["titu_numtitulo"];
                $sub_array[] = $row["titu_partlote"];
                $sub_array[] = $row["titu_asiento"];
                $sub_array[] = $row["titu_serie"];
                $sub_array[] = $row["titu_tipo"];
                $sub_array[] = $row["titu_tazacion"];
                $sub_array[] = $row["titu_numresolucion"];
                $sub_array[] = $row["titu_fecharesolucion"];
                $sub_array[] = $row["titu_fechaemision"];
                $sub_array[] = $validar_firmar_adj;
                $sub_array[] = '
                    <td class="dropdown hidden-xs-down show">
                        <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info" aria-expanded="true"><i class="icon ion-more"></i></a>
                        <div class="dropdown-menu dropdown-menu-left pd-10">
                            <nav class="nav nav-style-1 flex-column">
                                <a href="#" class="btn btn-brown" class="nav-link" onclick="abrir(' . $row["titu_id"] . ')">Generar</a>
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

        case "listar_titulos_pendiente_gerente":
            $datos=$titulo->get_titulo_detalle_gerente_pendiente();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $impreso = ($row["titu_estimp"] == 0) ? '' : '<span class="status-box status-imp">I</span>';
                $adjunto_symbol = ($row["titu_estadj"] == 0) ? '' : '<a href="#" class="fa fa-file-upload file-upload-icon" onclick="vistaprevia(' . $row["titu_id"] . ')"></a>';

                $validar_adjuntar_estimp = ($row["titu_estimp"] == 1) ? '<a href="#" class="btn btn-darkblue" class="nav-link" onclick="adjuntar(' . $row["titu_id"] . ')">Adjuntar</a>' :  '';
                $validar_firmar = ($row["titu_estfirma"] == 2) ? '<button class="btn btn-success" style="background-color: blue; border-color: blue;" onclick="firmar(' . $row["titu_id"] . ')">Firmar</button>': '';
                $validar_firmar_adj = ($row["titu_estadj"] == 0) ? '': $validar_firmar;
        
                $sub_array[] = $impreso;
                $sub_array[] = $row["datospropietarios"];
                $sub_array[] = $row["titu_partelec"];
                $sub_array[] = $row["titu_numtitulo"];
                $sub_array[] = $row["titu_partlote"];
                $sub_array[] = $row["titu_asiento"];
                $sub_array[] = $row["titu_serie"];
                $sub_array[] = $row["titu_tipo"];
                $sub_array[] = $row["titu_tazacion"];
                $sub_array[] = $row["titu_numresolucion"];
                $sub_array[] = $row["titu_fecharesolucion"];
                $sub_array[] = $row["titu_fechaemision"];
                $sub_array[] = $validar_firmar_adj;
                $sub_array[] = '
                    <td class="dropdown hidden-xs-down show">
                        <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info" aria-expanded="true"><i class="icon ion-more"></i></a>
                        <div class="dropdown-menu dropdown-menu-left pd-10">
                            <nav class="nav nav-style-1 flex-column">
                                <a href="#" class="btn btn-brown" class="nav-link" onclick="abrir(' . $row["titu_id"] . ')">Generar</a>
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
        case "listar_titulos_pendiente_alcalde":
            $datos=$titulo->get_titulo_detalle_alcalde_pendiente();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $impreso = ($row["titu_estimp"] == 0) ? '' : '<span class="status-box status-imp">I</span>';
                $adjunto_symbol = ($row["titu_estadj"] == 0) ? '' : '<a href="#" class="fa fa-file-upload file-upload-icon" onclick="vistaprevia(' . $row["titu_id"] . ')"></a>';

                $validar_adjuntar_estimp = ($row["titu_estimp"] == 1) ? '<a href="#" class="btn btn-darkblue" class="nav-link" onclick="adjuntar(' . $row["titu_id"] . ')">Adjuntar</a>' :  '';
                $validar_firmar = ($row["titu_estfirma"] == 3) ? '<button class="btn btn-success" style="background-color: blue; border-color: blue;" onclick="firmar(' . $row["titu_id"] . ')">Firmar</button>': '';
                $validar_firmar_adj = ($row["titu_estadj"] == 0) ? '': $validar_firmar;
        
                $sub_array[] = $impreso;
                $sub_array[] = $row["datospropietarios"];
                $sub_array[] = $row["titu_partelec"];
                $sub_array[] = $row["titu_numtitulo"];
                $sub_array[] = $row["titu_partlote"];
                $sub_array[] = $row["titu_asiento"];
                $sub_array[] = $row["titu_serie"];
                $sub_array[] = $row["titu_tipo"];
                $sub_array[] = $row["titu_tazacion"];
                $sub_array[] = $row["titu_numresolucion"];
                $sub_array[] = $row["titu_fecharesolucion"];
                $sub_array[] = $row["titu_fechaemision"];
                $sub_array[] = $validar_firmar_adj;
                $sub_array[] = '
                    <td class="dropdown hidden-xs-down show">
                        <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info" aria-expanded="true"><i class="icon ion-more"></i></a>
                        <div class="dropdown-menu dropdown-menu-left pd-10">
                            <nav class="nav nav-style-1 flex-column">
                                <a href="#" class="btn btn-brown" class="nav-link" onclick="abrir(' . $row["titu_id"] . ')">Generar</a>
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
        case "mostrar_titulo_propietario_completado":
            $datos=$titulo->get_titulo_detalle_completado();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                    $sub_array[] = $row["datospropietarios"];
                    $sub_array[] = $row["cert_area"];
                    $sub_array[] = $row["cert_distrito"] ." , ". $row["cert_ubicacion"] ." , ". $row["cert_manzana"] ." , ". $row["cert_lote"] ." , ". $row["cert_tipopobl"] ." ". $row["cert_nompobl"];
                    $sub_array[] = $row["cert_frente"];
                    $sub_array[] = $row["cert_derecha"];
                    $sub_array[] = $row["cert_izquierda"];
                    $sub_array[] = $row["cert_fondo"];
                    $sub_array[] = $row["titu_partelec"];
                    $sub_array[] = $row["titu_numtitulo"];
                    $sub_array[] = $row["titu_partlote"];
                    $sub_array[] = $row["titu_asiento"];
                    $sub_array[] = $row["titu_serie"];
                    $sub_array[] = $row["titu_tipo"];
                    $sub_array[] = $row["titu_tazacion"];
                    $sub_array[] = $row["titu_numresolucion"];
                    $sub_array[] = $row["titu_fecharesolucion"];
                    $sub_array[] = $row["titu_fechaemision"];
                    $sub_array[] = $row["titu_fecharegistro"];
                    $sub_array[] = $row["alca_nom"] ." , ". $row["alca_apep"] ." , ". $row["alca_apem"];
                    $sub_array[] = $row["alca_dni"];
                $sub_array[] = '
                        <td class="dropdown hidden-xs-down show">
                            <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info" aria-expanded="true" ><i class="icon ion-more"></i></a>
                            <div class="dropdown-menu dropdown-menu-left pd-10">
                                <nav class="nav nav-style-1 flex-column">
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
        case "mostrar_titulo_detalle":
            $datos=$titulo->get_propietarios_x_id_titulo($_POST["titu_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output[] = [
                        "titu_id" => $row["titu_id"],
                        "titu_partelec" => $row["titu_partelec"],
                        "titu_numtitulo" => $row["titu_numtitulo"],
                        "titu_partlote" => $row["titu_partlote"],
                        "titu_asiento" => $row["titu_asiento"],
                        "titu_serie" => $row["titu_serie"],
                        "titu_tipo" => $row["titu_tipo"],
                        "titu_tazacion" => $row["titu_tazacion"],
                        "titu_emp" => $row["titu_emp"],
                        "titu_sector" => $row["titu_sector"],
                        "titu_numresolucion" => $row["titu_numresolucion"],
                        "titu_fecharesolucion" => $row["titu_fecharesolucion"],
                        "titu_fechaemision" => $row["titu_fechaemision"],
                        "titu_fecharegistro" => $row["titu_fecharegistro"],
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
                        "cert_ubicacion" => $row["cert_ubicacion"],
                        "cert_nompobl" => $row["cert_nompobl"],
                        "cert_tipopobl" => $row["cert_tipopobl"],
                        "cert_frente" => $row["cert_frente"],
                        "cert_derecha" => $row["cert_derecha"],
                        "cert_izquierda" => $row["cert_izquierda"],
                        "cert_fondo" => $row["cert_fondo"],
                        "cert_manzana" => $row["cert_manzana"],
                        "cert_lote" => $row["cert_lote"],
                        "cert_distrito" => $row["cert_distrito"],
                        "cert_provincia" => $row["cert_provincia"],
                        "cert_departamento" => $row["cert_departamento"],
                        "alca_id" => $row["alca_id"],
                        "alca_dni" => $row["alca_dni"],
                        "alca_nom" => $row["alca_nom"],
                        "alca_apep" => $row["alca_apep"],
                        "alca_apem" => $row["alca_apem"]];
            }
            echo json_encode($output);
        }
        case "editar_modal_titulo":
            $datos = $titulo->get_titulo_id($_POST["titu_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    
                    
                    $output["titu_id"] = $row["titu_id"];
                    $output["cert_id"] = $row["cert_id"];
                    $output["alca_id"] = $row["alca_id"];
                    $output["titu_partelec"] = $row["titu_partelec"];
                    $output["titu_partlote"] = $row["titu_partlote"];
                    $output["titu_asiento"] = $row["titu_asiento"];
                    $output["titu_serie"] = $row["titu_serie"];
                    $output["titu_tipo"] = $row["titu_tipo"];
                    $output["titu_tazacion"] = $row["titu_tazacion"];
                    $output["titu_emp"] = $row["titu_emp"];
                    $output["titu_sector"] = $row["titu_sector"];
                    $output["titu_numresolucion"] = $row["titu_numresolucion"];
                    $output["titu_fecharesolucion"] = $row["titu_fecharesolucion"];
                    $output["titu_fechaemision"] = $row["titu_fechaemision"];
                    $output["titu_numrecibo"] = $row["titu_numrecibo"];
                    $output["titu_numtitulo"] = $row["titu_numtitulo"];
                   
                    
                }
                echo json_encode($output);
            }
            break;
            
        case 'imprimir':

            if (isset($_POST['titu_id'])) {
                $datosPropietarios = $propietario->get_propietario_x_id_titulo($_POST["titu_id"]);
                $datosTitulo = $titulo->get_datostitulo_x_id_titulo($_POST["titu_id"]);
                $datosAlcalde = $alcalde->get_alcalde_activo();

                $alcaNombreCompleto = strtoupper($datosAlcalde[0]['alca_nom'].' '.$datosAlcalde[0]['alca_apep'].' '.$datosAlcalde[0]['alca_apem']);
                

                if (!empty($datosPropietarios) && !empty($datosTitulo)) {
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
                $pdf->SetFont('Arial', '', 10);

                $pdf->SetMargins(15, 15, 15); // Márgenes izquierdo, superior, derecho
                $pdf->SetAutoPageBreak(true, 10); // Ha

                $posXImagenCentrada = ($pdf->GetPageWidth() - 20) / 2; // Centrar la imagen
                $pdf->Image('../public/logo144.png', $posXImagenCentrada, 10, 20);
                $imagenY = $pdf->GetY(); // Guardar la posición Y después de la imagen
                $imagenX = $pdf->GetX(); 
                $pdf->Ln(25); // Espacio después de la imagen

                // Encabezado

                $pdf->SetFont('Arial', 'B', 10);
                $texto = "MUNICIPALIDAD PROVINCIAL DE CHICLAYO\n";
                $texto .= "GERENCIA DE DESARROLLO URBANO\n";
                $texto .= "SUBGERENCIA DE OBRAS PRIVADAS";
                // Crear una celda invisible para posicionar el bloque de texto centrado
                $pdf->MultiCell(0, 4, utf8_decode($texto), 0, 'C');
                $pdf->Ln(5);
               
                
                // Cuerpo del documento
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(0, 4, utf8_decode('LA MUNICIPALIDAD PROVINCIAL DE CHICLAYO, debidamente representada por su Alcalde(sa),'.$datosAlcalde[0]['alca_nom'].' '.$datosAlcalde[0]['alca_apep'].' '.$datosAlcalde[0]['alca_apem'].' , que se identifica con el documento de identidad N° '.$datosAlcalde[0]['alca_dni'].', conforme facultades otorgadas en la Ley Orgánica de Municipalidades, Ley N° 27972, declara ser propietaria del Predio Matriz inscrito en la Partida Electrónica N° '.$datosTitulo[0]['titu_partelec'].' - Zona Registral N° II - Sede Chiclayo, sobre la cual se encuentra asentado en '.$datosTitulo[0]['tivi_descripcion'].' '.$datosTitulo[0]['cert_nomtipovia'].', razón por la cual y conforme a lo establecido en la Ley 31056 y su Reglamento D.S. N° 002-2021-Vivienda, la Entidad procede a realizar la lotización con fines de saneamiento, cuyos planos definitivos aprobados de trazado y lotización se encuentran inscritos en la citada partida.'), 0, 'J');
                $pdf->Ln(3);
            
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(0, 4, utf8_decode('LA MUNICIPALIDAD PROVINCIAL DE CHICLAYO, adquirió del Estado el predio de propiedad privada el dominio del citado terreno, en virtud a lo dispuesto por la Ley Orgánica de Municipalidades N° 27972, Ley N° 28923, D.S. N° 008-2007-VIVIENDA, Ley N° 31056 y D.S. N° 002-2021-VIVIENDA, encontrándose facultada para realizar la transferencia de propiedad de los lotes resultantes, a los posesionarios que hayan acreditado su derecho de conformidad con las normas antes indicadas, bajo los términos y condiciones siguientes:'), 0, 'J');
                $pdf->Ln(3);

                
                $pdf->SetFont('Arial', '', 8);
                if (count($datosPropietarios) == 1) {
                    $pdf->MultiCell(0, 4, utf8_decode('PRIMERA: Que don(ña), ' . $datosPropietarios[0]['prop_nombre'] . ' ' . $datosPropietarios[0]['prop_apep'] . ' ' . $datosPropietarios[0]['prop_apem'] . ', con DNI N° ' . $datosPropietarios[0]['prop_dni'] . ', de estado civil ' . $datosPropietarios[0]['prop_estadocivil'] . ' y don(ña) _______________, con DNI N° _______________, de estado civil _______________, a quienes en lo sucesivo se denominará(n) PROPIETARIO(S), han acreditado reunir los requisitos que establece la ley, además con el respectivo empadronamiento, por lo que se procede otorgarle, el TITULO DE PROPIEDAD del Lote N° ' . $datosTitulo[0]['cert_lote'] . ', de la manzana ' . $datosTitulo[0]['cert_manzana'] . ', Sector '. $datosTitulo[0]['titu_sector'] .' , Distrito de Chiclayo, Provincia Chiclayo, Departamento Lambayeque, inscrito en la Partida Electrónica N° ' . $datosTitulo[0]['titu_partelec'] . ', cuyas características se señalan en la cláusula siguiente:'), 0, 'J');
                } else if (count($datosPropietarios) == 2){
                    $pdf->MultiCell(0, 4, utf8_decode('PRIMERA: Que don(ña), ' . $datosPropietarios[0]['prop_nombre'] . ' ' . $datosPropietarios[0]['prop_apep'] . ' ' . $datosPropietarios[0]['prop_apem'] . ', con DNI N° ' . $datosPropietarios[0]['prop_dni'] . ', de estado civil ' . $datosPropietarios[0]['prop_estadocivil'] . ' y don(ña) ' . $datosPropietarios[1]['prop_nombre'] . ' ' . $datosPropietarios[1]['prop_apep'] . ' ' . $datosPropietarios[1]['prop_apem'] . ', con DNI N° ' . $datosPropietarios[1]['prop_dni'] . ', de estado civil ' . $datosPropietarios[1]['prop_estadocivil'] . ', a quienes en lo sucesivo se denominará(n) PROPIETARIO(S), han acreditado reunir los requisitos que establece la ley, además con el respectivo empadronamiento, por lo que se procede otorgarle, el TITULO DE PROPIEDAD del Lote N° ' . $datosTitulo[0]['cert_lote'] . ', de la manzana ' . $datosTitulo[0]['cert_manzana'] . ', Sector '. $datosTitulo[0]['titu_sector'] .' , Distrito de Distrito de Chiclayo, Provincia Chiclayo, Departamento Lambayeque, inscrito en la Partida Electrónica N° ' . $datosTitulo[0]['titu_partelec'] . ', cuyas características se señalan en la cláusula siguiente:'), 0, 'J');
                }

                $pdf->Ln(3);

                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(0, 4, utf8_decode('SEGUNDA: El lote materia de este TITULO DE PROPIEDAD, tiene un área de '. $datosTitulo[0]['cert_area'] .' m2, encerrado en los siguientes linderos y medidas perimétricas:'), 0, 'J');
                $pdf->Ln(3);

                $pdf->SetFont('Arial', 'B', 8);
                $left_margin = 15;
                $label_width = 60;  // Ancho para las etiquetas
                $colon_width = 5;   // Ancho para los dos puntos
                $value_width = 60;  // Ancho para los valores

                $linderos = [
                    ['label' => 'Por el Frente', 'value' => $datosTitulo[0]['cert_frente']],
                    ['label' => 'Por la Derecha', 'value' => $datosTitulo[0]['cert_derecha']],
                    ['label' => 'Por la Izquierda', 'value' => $datosTitulo[0]['cert_izquierda']],
                    ['label' => 'Por el Fondo', 'value' => $datosTitulo[0]['cert_fondo']]
                ];

                foreach ($linderos as $lindero) {
                    $pdf->SetX($left_margin);
                    $pdf->Cell($label_width, 4, utf8_decode($lindero['label']), 0, 0, 'L');
                    $pdf->Cell($colon_width, 4, utf8_decode(':'), 0, 0, 'L');
                    $pdf->Cell($value_width, 4, utf8_decode($lindero['value']), 0, 1, 'L');
                }
                $pdf->Ln(3);

                $pdf->SetFont('Arial', '', 8);
                $clausulas = [
                    'TERCERA' => 'La presente transferencia de propiedad del lote de terreno antes mencionado, se otorga a título '. $datosTitulo[0]['titu_tipo'] .', en aplicación del Art. 73 numeral 1, 1.4 del Art. 79.11.3.4, de la Ley orgánica de Municipalidades N° 27972, Ley N° 28687, D.S. N° 006-2006-VIVIENDA, Ley N° 28923, D.S. N° 008-2007-VIVIENDA, Ley N° 31056 y D.S. N° 002-2021-VIVIENDA.',
                    'CUARTA' => 'Este TITULO otorga la propiedad del Lote "AD CORPUS", como cosa cierta y determinada e incluye aires, usos, costumbres y servidumbres sin reserva ni limitación alguna, siempre que cumpla con la Carga señalada en la Cláusula Cuarta.',
                    'QUINTA' => 'El lote de terreno, materia del presente TITULO DE PROPIEDAD, será revertido al dominio de la Municipalidad Provincial de Chiclayo, si esta comprobara que el (los) PROPIETARIO (S) tiene otra propiedad en cualquier Asentamiento Humano Marginal, urbanización y otros de la República, con fecha anterior a la emisión del presente título.',
                    'SEXTA' => 'Este TITULO DE PROPIEDAD, constituye mérito suficiente para su inscripción en la SUPERINTENDENCIA NACIONAL DE REGISTROS PUBLICOS, Zona Registral II de Sede Chiclayo, conforme a lo dispuesto por la Ley Orgánica de Municipalidades N° 27972 y Ley N° 28687 y DS N° 006-2006-VIVIENDA, Ley N° 28923, DS N° 006-2007-VIVIENDA-VIVIENDA, Ley N° 31056 y su Reglamento D.S. N° 002-2021-VIVIENDA.',
                    'SEPTIMA' => 'La Municipalidad Provincial de Chiclayo, emite el presente TITULO DE PROPIEDAD, en armonía con los criterios señalados por el Ministerio de Vivienda, Construcción y Saneamiento y lo dispuesto en el Decreto Supremo N° 013-99-MTC y la Resolución Gerencia de Desarrollo Urbano N° N° 047-2023-MPCH-GDU, de fecha 20 de Marzo del 2023.'
                ];

                foreach ($clausulas as $titulo => $contenido) {
                    $pdf->MultiCell(0, 4, utf8_decode("$titulo: $contenido"), 0, 'J');
                    $pdf->Ln(3);
                }
                

                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(0, 10, utf8_decode('Chiclayo, '.$datosTitulo[0]['titu_fechcrea']), 0, 1, 'R');
                $pdf->Ln(10);

                
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
                $pdf->Cell($firmWidth, $firmHeight, utf8_decode('Subgerente'), 0, 1, 'C');

                // Imprimir la segunda firma
                $pdf->SetY($startY);
                $pdf->SetX($startX + $firmWidth + $spacing); // Ajustar el espacio entre las firmas
                $pdf->Cell($firmWidth, $firmHeight, utf8_decode('....................................'), 0, 0, 'C');
                $pdf->Ln(); // Nueva línea para el texto debajo de la firma
                $pdf->SetX($startX + $firmWidth + $spacing);
                $pdf->Cell($firmWidth, $firmHeight, utf8_decode('Gerente'), 0, 1, 'C');

                // Imprimir la tercera firma
                $pdf->SetY($startY);
                $pdf->SetX($startX + 2 * ($firmWidth + $spacing)); // Ajustar el espacio entre las firmas
                $pdf->Cell($firmWidth, $firmHeight, utf8_decode('....................................'), 0, 0, 'C');
                $pdf->Ln(); // Nueva línea para el texto debajo de la firma
                $pdf->SetX($startX + 2 * ($firmWidth + $spacing));
                $pdf->Cell($firmWidth, $firmHeight, utf8_decode('Alcalde'), 0, 1, 'C');
        
                
                // Salida del PDF
                $pdf_content = $pdf->Output('S');

                // Envía el PDF al navegador
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="Titulo_de_Propiedad.pdf"');
                echo $pdf_content;
            }
                } else {
                    // Manejar el caso cuando no hay datos
                    echo "No se encontraron datos para generar el PDF.";
                }
            
            break;
            case 'generar_reporte':
                require_once("../public/plantilla_reporte_excel.php");
                
                // Obtener los parámetros desde POST
                $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
                $completo = isset($_POST['completo']) ? $_POST['completo'] : '';
                $urb = isset($_POST['urb']) ? $_POST['urb'] : '';
                
                // Obtener datos desde el método get_certificado_
                $datosExcel = $titulo->get_titulo_resumen($fecha, $completo, $urb);
                
                // Crear una instancia de la clase ExcelReport
                $report = new ExcelReport();
                
                // Establecer título para el archivo Excel
                $report->setTitle('Reporte de Títulos');
                
                // Establecer encabezados para el archivo Excel
                $headers = [
                    'PARTIDA ELECTRONICA', 'SERIE', 'Nº DE TITULO DE PROPIEDAD',
                    'TIPO DE URBANIZACION', 'Mz.', 'LOTE', 'EMPADRON.',
                    'ASIENTO', 'PROPIETARIO (1)', 'DNI (1)', 'ESTADO CIVIL (1)',
                    'PROPIETARIO (2)', 'DNI (2)', 'ESTADO CIVIL (2)',
                    'PARTIDA ELECTRONICA DE LOTE', 'AREA', 'POR EL FRENTE',
                    'POR LA DERECHA ENTRANDO', 'POR LA IZQUIERDA ENTRANDO',
                    'POR FONDO',
                    'TIPO DE TITULO', 'RESOLUCION GERENCIAL',
                    'FECHA DE EMISION RESOLUCION', 'FECHA DE EMISION DE TITULO'
                ];
                $report->setHeaders($headers);
                
                // Agregar filas de datos al archivo Excel
                foreach ($datosExcel as $row) {
                    $report->addRow([
                        $row['titu_partelec'], 
                        $row['titu_serie'], 
                        $row['titu_numtitulo'],
                        $row["tiur_abr"].' '.$row["cert_nomtipourb"],
                        $row["cert_manzana"], 
                        $row["cert_lote"],
                        $row["titu_emp"], 
                        $row["titu_asiento"], 
                        $row["prop_nombre1"].' '.$row["prop_apep1"].' '.$row["prop_apem1"],
                        $row["prop_dni1"], 
                        $row["prop_estadocivil1"], 
                        $row["prop_nombre2"].' '.$row["prop_apep2"].' '.$row["prop_apem2"],
                        $row['prop_dni2'], 
                        $row['prop_estadocivil2'], 
                        $row['titu_partlote'],
                        $row['cert_area'], 
                        $row['cert_frente'].' con , '.$row['cert_medfrente'].' mL ', 
                        $row['cert_derecha'].' con , '.$row['cert_medderecha'].'mL ', 
                        $row['cert_izquierda'].' con , '.$row['cert_medizquierda'].' mL ',
                        $row['cert_fondo'].' con , '.$row['cert_medfondo'].' mL ',
                        $row['titu_tipo'], 
                        $row['titu_numresolucion'].'-2022-MPCH-GDU',
                        $row['titu_fecharesolucion'], 
                        $row['titu_fechaemision']
                    ]);
                }
                
                // Descargar el archivo Excel
                $report->download('reporte_titulo.xlsx');
                break;

            
            case 'imprimir_x_imp':
                $idtitulosSINIMP = $titulo->get_titulo_x_estimp();
            
                if (!empty($idtitulosSINIMP)) {
                    $pdf = new PDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->SetMargins(15, 15, 15); // Márgenes izquierdo, superior, derecho
                    $pdf->SetAutoPageBreak(true, 10); // Altura mínima para salto de página
            
                    foreach ($idtitulosSINIMP as $tit) {
                        $titu_id = $tit['titu_id'];
            
                        $datosPropietarios = $propietario->get_propietario_x_id_titulo($titu_id);
                        $datosTitulo = $titulo->get_datostitulo_x_id_titulo($titu_id);
                        $datosAlcalde = $alcalde->get_alcalde_activo();
            
                        $alcaNombreCompleto = strtoupper($datosAlcalde[0]['alca_nom'].' '.$datosAlcalde[0]['alca_apep'].' '.$datosAlcalde[0]['alca_apem']);
            
                        if (!empty($datosPropietarios) && !empty($datosTitulo)) {
                            $posXImagenCentrada = ($pdf->GetPageWidth() - 20) / 2; // Centrar la imagen
                            $pdf->Image('../public/logo144.png', $posXImagenCentrada, 10, 20);
                            $imagenY = $pdf->GetY(); // Guardar la posición Y después de la imagen
                            $imagenX = $pdf->GetX(); 
                            $pdf->Ln(25); // Espacio después de la imagen
            
                            // Encabezado
            
                            $pdf->SetFont('Arial', 'B', 10);
                            $texto = "MUNICIPALIDAD PROVINCIAL DE CHICLAYO\n";
                            $texto .= "GERENCIA DE DESARROLLO URBANO\n";
                            $texto .= "SUBGERENCIA DE OBRAS PRIVADAS";
                            // Crear una celda invisible para posicionar el bloque de texto centrado
                            $pdf->MultiCell(0, 4, utf8_decode($texto), 0, 'C');
                            $pdf->Ln(5);
            
                            // Cuerpo del documento
                            $pdf->SetFont('Arial', '', 8);
                            $pdf->MultiCell(0, 4, utf8_decode('LA MUNICIPALIDAD PROVINCIAL DE CHICLAYO, debidamente representada por su Alcalde(sa), '.$alcaNombreCompleto.', que se identifica con el documento de identidad N° '.$datosAlcalde[0]['alca_dni'].', conforme facultades otorgadas en la Ley Orgánica de Municipalidades, Ley N° 27972, declara ser propietaria del Predio Matriz inscrito en la Partida Electrónica N° '.$datosTitulo[0]['titu_partelec'].' - Zona Registral N° II - Sede Chiclayo, sobre la cual se encuentra asentado en '.$datosTitulo[0]['tivi_descripcion'].' '.$datosTitulo[0]['cert_nomtipovia'].', razón por la cual y conforme a lo establecido en la Ley 31056 y su Reglamento D.S. N° 002-2021-Vivienda, la Entidad procede a realizar la lotización con fines de saneamiento, cuyos planos definitivos aprobados de trazado y lotización se encuentran inscritos en la citada partida.'), 0, 'J');
                            $pdf->Ln(3);
            
                            $pdf->MultiCell(0, 4, utf8_decode('LA MUNICIPALIDAD PROVINCIAL DE CHICLAYO, adquirió del Estado el predio de propiedad privada el dominio del citado terreno, en virtud a lo dispuesto por la Ley Orgánica de Municipalidades N° 27972, Ley N° 28923, D.S. N° 008-2007-VIVIENDA, Ley N° 31056 y D.S. N° 002-2021-VIVIENDA, encontrándose facultada para realizar la transferencia de propiedad de los lotes resultantes, a los posesionarios que hayan acreditado su derecho de conformidad con las normas antes indicadas, bajo los términos y condiciones siguientes:'), 0, 'J');
                            $pdf->Ln(3);
            
                            $pdf->SetFont('Arial', '', 8);
                            if (count($datosPropietarios) == 1) {
                                $pdf->MultiCell(0, 4, utf8_decode('PRIMERA: Que don(ña), ' . $datosPropietarios[0]['prop_nombre'] . ' ' . $datosPropietarios[0]['prop_apep'] . ' ' . $datosPropietarios[0]['prop_apem'] . ', con DNI N° ' . $datosPropietarios[0]['prop_dni'] . ', de estado civil ' . $datosPropietarios[0]['prop_estadocivil'] . ' y don(ña) _______________, con DNI N° _______________, de estado civil _______________, a quienes en lo sucesivo se denominará(n) PROPIETARIO(S), han acreditado reunir los requisitos que establece la ley, además con el respectivo empadronamiento, por lo que se procede otorgarle, el TITULO DE PROPIEDAD del Lote N° ' . $datosTitulo[0]['cert_lote'] . ', de la manzana ' . $datosTitulo[0]['cert_manzana'] . ', Sector '. $datosTitulo[0]['titu_sector'] .' , Distrito de Chiclayo, Provincia Chiclayo, Departamento Lambayeque, inscrito en la Partida Electrónica N° ' . $datosTitulo[0]['titu_partelec'] . ', cuyas características se señalan en la cláusula siguiente:'), 0, 'J');
                            } else if (count($datosPropietarios) == 2){
                                $pdf->MultiCell(0, 4, utf8_decode('PRIMERA: Que don(ña), ' . $datosPropietarios[0]['prop_nombre'] . ' ' . $datosPropietarios[0]['prop_apep'] . ' ' . $datosPropietarios[0]['prop_apem'] . ', con DNI N° ' . $datosPropietarios[0]['prop_dni'] . ', de estado civil ' . $datosPropietarios[0]['prop_estadocivil'] . ' y don(ña) ' . $datosPropietarios[1]['prop_nombre'] . ' ' . $datosPropietarios[1]['prop_apep'] . ' ' . $datosPropietarios[1]['prop_apem'] . ', con DNI N° ' . $datosPropietarios[1]['prop_dni'] . ', de estado civil ' . $datosPropietarios[1]['prop_estadocivil'] . ', a quienes en lo sucesivo se denominará(n) PROPIETARIO(S), han acreditado reunir los requisitos que establece la ley, además con el respectivo empadronamiento, por lo que se procede otorgarle, el TITULO DE PROPIEDAD del Lote N° ' . $datosTitulo[0]['cert_lote'] . ', de la manzana ' . $datosTitulo[0]['cert_manzana'] . ', Sector '. $datosTitulo[0]['titu_sector'] .' , Distrito de Chiclayo, Provincia Chiclayo, Departamento Lambayeque, inscrito en la Partida Electrónica N° ' . $datosTitulo[0]['titu_partelec'] . ', cuyas características se señalan en la cláusula siguiente:'), 0, 'J');
                            }
            
                            $pdf->Ln(3);
                            $pdf->SetFont('Arial', '', 8);
                            $pdf->MultiCell(0, 4, utf8_decode('SEGUNDA: El lote materia de este TITULO DE PROPIEDAD, tiene un área de '. $datosTitulo[0]['cert_area'] .' m2, encerrado en los siguientes linderos y medidas perimétricas:'), 0, 'J');
                            $pdf->Ln(3);
            
                            $pdf->SetFont('Arial', 'B', 8);
                            $left_margin = 15;
                            $label_width = 60;  // Ancho para las etiquetas
                            $colon_width = 5;   // Ancho para los dos puntos
                            $value_width = 60;  // Ancho para los valores
            
                            $linderos = [
                                ['label' => 'Por el Frente', 'value' => $datosTitulo[0]['cert_frente']],
                                ['label' => 'Por la Derecha', 'value' => $datosTitulo[0]['cert_derecha']],
                                ['label' => 'Por la Izquierda', 'value' => $datosTitulo[0]['cert_izquierda']],
                                ['label' => 'Por el Fondo', 'value' => $datosTitulo[0]['cert_fondo']]
                            ];
            
                            foreach ($linderos as $lindero) {
                                $pdf->SetX($left_margin);
                                $pdf->Cell($label_width, 4, utf8_decode($lindero['label']), 0, 0, 'L');
                                $pdf->Cell($colon_width, 4, utf8_decode(':'), 0, 0, 'L');
                                $pdf->Cell($value_width, 4, utf8_decode($lindero['value']),0, 1, 'L');
                            }
            
                            $pdf->Ln(3);
                            $pdf->SetFont('Arial', '', 8);
                            $pdf->MultiCell(0, 4, utf8_decode('TERCERA: El PROPIETARIO se compromete a respetar las normas y regulaciones establecidas por la municipalidad y a mantener en buen estado las instalaciones del predio, así como a cumplir con el pago de los tributos correspondientes.'), 0, 'J');
                            $pdf->Ln(3);
            
                            $pdf->MultiCell(0, 4, utf8_decode('CUARTA: El presente TÍTULO DE PROPIEDAD se emite en cumplimiento de las normas vigentes y constituye un documento válido para todos los efectos legales.'), 0, 'J');
                            $pdf->Ln(3);
            
                            $pdf->MultiCell(0, 4, utf8_decode('QUINTA: El presente documento se firma en señal de conformidad por las partes involucradas y se entrega en duplicado, quedando un ejemplar en poder de la municipalidad y otro en poder del PROPIETARIO.'), 0, 'J');
                            $pdf->Ln(3);
            
                            $pdf->MultiCell(0, 4, utf8_decode('SEXTA: Este TITULO DE PROPIEDAD, constituye mérito suficiente para su inscripción en la SUPERINTENDENCIA NACIONAL DE REGISTROS PUBLICOS, Zona Registral II de Sede Chiclayo, conforme a lo dispuesto por la Ley Orgánica de Municipalidades N° 27972 y Ley N° 28687 y DS N° 006-2006-VIVIENDA, Ley N° 28923, DS N° 006-2007-VIVIENDA-VIVIENDA, Ley N° 31056 y su Reglamento D.S. N° 002-2021-VIVIENDA'), 0, 'J');
                            $pdf->Ln(3);

                            $pdf->MultiCell(0, 4, utf8_decode('SEPTIMA: La Municipalidad Provincial de Chiclayo, emite el presente TITULO DE PROPIEDAD, en armonía con los criterios señalados por el Ministerio de Vivienda, Construcción y Saneamiento y lo dispuesto en el Decreto Supremo N° 013-99-MTC y la Resolución Gerencia de Desarrollo Urbano N° N° 047-2023-MPCH-GDU, de fecha 20 de Marzo del 2023.'), 0, 'J');
                            $pdf->Ln(3);
                            $pdf->SetFont('Arial', 'B', 8);
                            $pdf->Cell(0, 10, utf8_decode('Chiclayo, '.$datosTitulo[0]['titu_fechcrea']), 0, 1, 'R');
                            $pdf->Ln(10);
            
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
                    
                            $titulo->cambiarestado_impreso($titu_id, 'impreso');
                            // Salto de página si no es el último
                            if ($tit !== end($idtitulosSINIMP)) {
                                $pdf->AddPage();
                            }
                        }
                    }
            
                    // Salida del PDF al navegador
                    $pdf->Output('I', 'TitulosPropiedad.pdf');
                } else {
                    echo 'No hay títulos pendientes de impresión.';
                }
                break;
                case 'imprimir_x_firm1':
                    $idtitulosFIRM1 = $titulo->get_titulo_x_firm1();
                    
                    // Inicializa FPDI
                    $pdf = new PDF();
                    $pdf->SetAutoPageBreak(true, 10); 
                
                    if (!empty($idtitulosFIRM1)) {
                        foreach ($idtitulosFIRM1 as $titu) {
                            $titu_id = $titu['titu_id'];
                            $datosPDF = $titulo->get_pdf_x_id_titulo($titu_id);
                
                            if (!empty($datosPDF)) {
                                
                                $pdfData = base64_decode($datosPDF['titu_firmapdf']);
                
                                
                                $tempFilePath = tempnam(sys_get_temp_dir(), 'titu') . '.pdf';
                                file_put_contents($tempFilePath, $pdfData);
                
                                // Añade todas las páginas del PDF decodificado al documento final
                                $pageCount = $pdf->setSourceFile($tempFilePath);
                                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                                    $tplIdx = $pdf->importPage($pageNo);
                                    $pdf->AddPage();
                                    $pdf->useTemplate($tplIdx);
                                }
                
                                // Cambia el estado del titulo a "impreso"
                                $titulo->cambiarestado_impreso($titu_id, 'impreso');
                            }
                        }
                
                        // Envía los encabezados para mostrar el PDF en el navegador
                        header('Content-Type: application/pdf');
                        header('Content-Disposition: inline; filename="Titulos.pdf"');
                
                        // Salida de todo el PDF combinado
                        $pdf->Output();
                
                    } else {
                        echo 'No hay certificados pendientes de impresión.';
                    }
                    break;
            case 'imprimir_x_firm2':
                $idtitulosFIRM2 = $titulo->get_titulo_x_firm2();
                
                // Inicializa FPDI
                $pdf = new PDF();
                $pdf->SetAutoPageBreak(true, 10); 
            
                if (!empty($idtitulosFIRM2)) {
                    foreach ($idtitulosFIRM2 as $titu) {
                        $titu_id = $titu['titu_id'];
                        $datosPDF = $titulo->get_pdf_x_id_titulo($titu_id);
            
                        if (!empty($datosPDF)) {
                            
                            $pdfData = base64_decode($datosPDF['titu_firmapdf']);
            
                            
                            $tempFilePath = tempnam(sys_get_temp_dir(), 'titu') . '.pdf';
                            file_put_contents($tempFilePath, $pdfData);
            
                            // Añade todas las páginas del PDF decodificado al documento final
                            $pageCount = $pdf->setSourceFile($tempFilePath);
                            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                                $tplIdx = $pdf->importPage($pageNo);
                                $pdf->AddPage();
                                $pdf->useTemplate($tplIdx);
                            }
            
                            // Cambia el estado del titulo a "impreso"
                            $titulo->cambiarestado_impreso($titu_id, 'impreso');
                        }
                    }
            
                    // Envía los encabezados para mostrar el PDF en el navegador
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: inline; filename="Titulos.pdf"');
            
                    // Salida de todo el PDF combinado
                    $pdf->Output();
            
                } else {
                    echo 'No hay certificados pendientes de impresión.';
                }
                break;
                case 'imprimir_x_firm3':
                    $idtitulosFIRM3 = $titulo->get_titulo_x_firm3();
                    
                    // Inicializa FPDI
                    $pdf = new PDF();
                    $pdf->SetAutoPageBreak(true, 10); 
                
                    if (!empty($idtitulosFIRM3)) {
                        foreach ($idtitulosFIRM3 as $titu) {
                            $titu_id = $titu['titu_id'];
                            $datosPDF = $titulo->get_pdf_x_id_titulo($titu_id);
                
                            if (!empty($datosPDF)) {
                                
                                $pdfData = base64_decode($datosPDF['titu_firmapdf']);
                
                                
                                $tempFilePath = tempnam(sys_get_temp_dir(), 'titu') . '.pdf';
                                file_put_contents($tempFilePath, $pdfData);
                
                                // Añade todas las páginas del PDF decodificado al documento final
                                $pageCount = $pdf->setSourceFile($tempFilePath);
                                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                                    $tplIdx = $pdf->importPage($pageNo);
                                    $pdf->AddPage();
                                    $pdf->useTemplate($tplIdx);
                                }
                
                                // Cambia el estado del titulo a "impreso"
                                $titulo->cambiarestado_impreso($titu_id, 'impreso');
                            }
                        }
                
                        // Envía los encabezados para mostrar el PDF en el navegador
                        header('Content-Type: application/pdf');
                        header('Content-Disposition: inline; filename="Titulos.pdf"');
                
                        // Salida de todo el PDF combinado
                        $pdf->Output();
                
                    } else {
                        echo 'No hay certificados pendientes de impresión.';
                    }
                    break;
            case "vistaprevia_pdf":
                $datos = $titulo->get_pdf_x_id_titulo_vista($_POST["titu_id"]);
                if ($datos && isset($datos['titu_firmapdf'])) {
                    echo $datos['titu_firmapdf'];
                } else {
                    header('HTTP/1.1 404 Not Found');
                    echo 'Archivo no encontrado';
                }
                break;
            
        case "total_registrados":
            $datos=$titulo->get_total_titulos_registrados();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["registrados"] = $row["registrados"];
                }
                echo json_encode($output);
            }
            break;
        case "total_pendientes":
            $datos=$titulo->get_total_titulos_pendientes();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["pendientes"] = $row["pendientes"];
                }
                echo json_encode($output);
            }
            break;
        case "total_pendientes_subgerente":
            $datos=$titulo->get_total_titulos_pendientes_subgerente();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["pendientes"] = $row["pendientes"];
                }
                echo json_encode($output);
            }
            break;
        case "total_pendientes_gerente":
            $datos=$titulo->get_total_titulos_pendientes_gerente();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["pendientes"] = $row["pendientes"];
                }
                echo json_encode($output);
            }
            break;
        case "total_pendientes_alcalde":
            $datos=$titulo->get_total_titulos_pendientes_alcalde();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["pendientes"] = $row["pendientes"];
                }
                echo json_encode($output);
            }
            break;
        case "total_descargables_subgerente":
            $datos=$titulo->get_total_titulos_descargables_subgerente();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["descargables"] = $row["descargables"];
                }
                echo json_encode($output);
            }
            break;
        case "total_descargables_gerente":
            $datos=$titulo->get_total_titulos_descargables_gerente();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["descargables"] = $row["descargables"];
                }
                echo json_encode($output);
            }
            break;
        case "total_descargables_alcalde":
            $datos=$titulo->get_total_titulos_descargables_alcalde();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["descargables"] = $row["descargables"];
                }
                echo json_encode($output);
            }
            break;
        case "total_completados":
            $datos=$titulo->get_total_titulos_completados();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["completados"] = $row["completados"];
                }
                echo json_encode($output);
            }
            break;
                
        case "mostrar_resumen_titulo":
            $datos=$titulo->get_resumen_titulo();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["nombrepoblacion"];
                $sub_array[] = $row["registrados"];
                $sub_array[] = $row["pendientes"];
                $sub_array[] = $row["completados"];
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
        case "obtener_titulo_abrir":
            $datos = $titulo->get_titulo_id_abrir($_POST["titu_id"]);
            if ($datos && isset($datos['titu_firmapdf'])) {
                echo $datos['titu_firmapdf'];
            } else {
                header('HTTP/1.1 404 Not Found');
                echo 'Archivo no encontrado';
            }
            break;
        case "cambiar_estimp":
            $titulo->cambiarestado_impreso($_POST["titu_id"]);
            break;
        
        case "cambiar_estnoimp":
            $titulo->cambiarestado_noimpreso($_POST["titu_id"]);
            break;
        
        case "cambiar_estcompleto":
            $titulo->cambiarestado_completo($_POST["titu_id"]);
            break;

        case "cambiar_estentrega":
            $titulo->cambiarestado_entrega($_POST["titu_id"]);
            break;

        case "cambiar_estadjuntado":
            $titulo->cambiarestado_adjuntado($_POST["titu_id"]);
            break;

        case "cambiar_estnoadjuntado":
            $titulo->cambiarestado_noadjuntado($_POST["titu_id"]);
            break;

        case "cambiar_estfirmado":
            $titulo->cambiarestado_firmado($_POST["titu_id"]);
            break;
        case "cambiar_estfirmado2":
            $titulo->cambiarestado_firmado2($_POST["titu_id"]);
            break;
        case "cambiar_estfirmado3":
            $titulo->cambiarestado_firmado3($_POST["titu_id"]);
            break;
        case "cambiar_estfirmado4":
            $titulo->cambiarestado_firmado4($_POST["titu_id"]);
            break;
        case "cambiar_estrecibo":
            $titulo->cambiarestado_recibo($_POST["titu_id"]);
            break;

            
        case "update_pdf":
            $titulo->update_pdf($_POST["titux_idx"],$_FILES["titu_firmapdf"]);
            break;
        case "eliminar":
            $titulo->delete_titulo($_POST["titu_id"]);
            break;
        }
        
                        
        ?>