<?php
    /* LLamando a cadena de conexion */
    require_once("../config/conexion.php");
    /* LLamando a la clase */
    require_once("../models/Distrito.php");
    /* Inicializando Clase */
    $distrito = new Distrito();


 switch($_GET["op"]){

    case "combo":
        $datos=$distrito->get_distrito();
        if(is_array($datos)==true and count($datos)>0){
            $html= " <option label='Seleccione'></option>";
            foreach($datos as $row){
                $html.= "<option value='".$row['dist_id']."'>".$row['dist_nom']."</option>";
            }
            echo $html;
        }
        break;
        
}
?>
