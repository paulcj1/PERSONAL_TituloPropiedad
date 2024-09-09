<?php
    /* LLamando a cadena de conexion */
    require_once("../config/conexion.php");
    /* LLamando a la clase */
    require_once("../models/Tipourbanizacion.php");
    /* Inicializando Clase */
    $tipourbanizacion = new Tipourbanizacion();


 switch($_GET["op"]){

    case "combo":
        $datos=$tipourbanizacion->get_tipourbanizacion();
        if(is_array($datos)==true and count($datos)>0){
            $html= " <option label='Seleccione'></option>";
            foreach($datos as $row){
                $html.= "<option value='".$row['tiur_id']."'>".$row['tiur_descripcion']."</option>";
            }
            echo $html;
        }
        break;
        
}
?>
